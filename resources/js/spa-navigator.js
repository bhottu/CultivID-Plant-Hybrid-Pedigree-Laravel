/**
 * SPA Navigation Manager
 * Handles smooth, AJAX-based page transitions without full page refresh
 */

class SPANavigator {
    constructor() {
        this.currentUrl = window.location.pathname;
        this.isLoading = false;
        this.transitionDuration = 300; // ms
        this.init();
    }

    init() {
        // Intercept all navigation links
        this.setupLinkInterception();
        
        // Handle browser back/forward
        window.addEventListener('popstate', (e) => this.handlePopState(e));
        
        // Alpine.js integration
        if (window.Alpine) {
            this.setupAlpineIntegration();
        }
    }

    setupLinkInterception() {
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (!link) return;

            const href = link.getAttribute('href');
            const isExternal = link.getAttribute('target') === '_blank' || 
                             link.getAttribute('rel')?.includes('external');
            const isAnchor = href?.startsWith('#');
            const isDownload = link.hasAttribute('download');

            // Skip external, anchor, download links, and non-HTTP(S) links
            if (isExternal || isAnchor || isDownload || !href?.startsWith('/')) {
                return;
            }

            // Skip login/logout/auth forms
            if (href.includes('login') || href.includes('register') || 
                href.includes('logout') || href.includes('forgot-password')) {
                return;
            }

            e.preventDefault();
            this.navigateTo(href);
        });
    }

    setupAlpineIntegration() {
        // Expose to Alpine templates
        window.spa = {
            navigate: (url) => this.navigateTo(url),
            isLoading: () => this.isLoading,
        };
    }

    async navigateTo(url) {
        if (this.isLoading || url === this.currentUrl) {
            return;
        }

        this.isLoading = true;
        
        try {
            // Add loading indicator
            this.showLoadingState();

            // Fetch page content
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-SPA-Request': 'true',
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const html = await response.text();

            // Fade out current content
            await this.transitionOut();

            // Update content
            this.updatePageContent(html);

            // Update URL
            window.history.pushState({ url }, '', url);
            this.currentUrl = url;

            // Reinitialize Alpine components
            if (window.Alpine?.discardRoot) {
                window.Alpine.discardRoot(document.documentElement);
            } else if (window.Alpine?.flushAndStopObserving) {
                window.Alpine.flushAndStopObserving();
            }

            // Fade in new content
            await this.transitionIn();

            // Scroll to top smoothly
            this.scrollToTop();

            // Dispatch custom event for other scripts
            window.dispatchEvent(new CustomEvent('spa:navigated', { 
                detail: { url, html } 
            }));

        } catch (error) {
            console.error('SPA Navigation Error:', error);
            // Fallback to full page reload
            window.location.href = url;
        } finally {
            this.isLoading = false;
            this.hideLoadingState();
        }
    }

    updatePageContent(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        // Extract and update content sections
        const newContent = doc.querySelector('#app-content');
        const currentContent = document.querySelector('#app-content');

        if (newContent && currentContent) {
            currentContent.innerHTML = newContent.innerHTML;
        }

        // Update page title if present
        const newTitle = doc.querySelector('title');
        if (newTitle) {
            document.title = newTitle.textContent;
        }

        // Update meta tags (og, description, etc)
        this.updateMetaTags(doc);

        // Reinitialize Alpine components in updated content
        this.reinitializeAlpine();
    }

    updateMetaTags(doc) {
        const metaTags = doc.querySelectorAll('meta[property], meta[name]');
        metaTags.forEach(tag => {
            const existing = document.querySelector(
                `meta[${tag.hasAttribute('property') ? 'property' : 'name'}="${
                    tag.getAttribute('property') || tag.getAttribute('name')
                }"]`
            );
            if (existing) {
                existing.setAttribute('content', tag.getAttribute('content'));
            } else {
                document.head.appendChild(tag.cloneNode());
            }
        });
    }

    reinitializeAlpine() {
        if (window.Alpine?.data) {
            // Reinitialization happens automatically with Alpine.discardRoot
        }
    }

    handlePopState(e) {
        const url = window.location.pathname;
        this.navigateTo(url);
    }

    showLoadingState() {
        let loader = document.getElementById('spa-loader');
        if (!loader) {
            loader = document.createElement('div');
            loader.id = 'spa-loader';
            loader.className = 'fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-600 z-50 animate-pulse';
            document.body.appendChild(loader);
        }
        loader.classList.remove('hidden');
    }

    hideLoadingState() {
        const loader = document.getElementById('spa-loader');
        if (loader) {
            setTimeout(() => loader.classList.add('hidden'), 300);
        }
    }

    async transitionOut() {
        const content = document.querySelector('#app-content');
        if (content) {
            content.style.transition = `opacity ${this.transitionDuration}ms ease-out`;
            content.style.opacity = '0';
            await this.sleep(this.transitionDuration);
        }
    }

    async transitionIn() {
        const content = document.querySelector('#app-content');
        if (content) {
            content.style.opacity = '0';
            content.offsetHeight; // Trigger reflow
            content.style.transition = `opacity ${this.transitionDuration}ms ease-in`;
            content.style.opacity = '1';
            await this.sleep(this.transitionDuration);
            content.style.transition = '';
        }
    }

    scrollToTop() {
        const content = document.querySelector('#app-content');
        if (content) {
            content.scrollTop = 0;
        }
    }

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.spaNavigator = new SPANavigator();
    });
} else {
    window.spaNavigator = new SPANavigator();
}
