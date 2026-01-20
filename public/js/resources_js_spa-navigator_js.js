(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_spa-navigator_js"],{

/***/ "./resources/js/spa-navigator.js":
/*!***************************************!*\
  !*** ./resources/js/spa-navigator.js ***!
  \***************************************/
/***/ (() => {

function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/**
 * SPA Navigation Manager
 * Handles smooth, AJAX-based page transitions without full page refresh
 */
var SPANavigator = /*#__PURE__*/function () {
  function SPANavigator() {
    _classCallCheck(this, SPANavigator);
    this.currentUrl = window.location.pathname;
    this.isLoading = false;
    this.transitionDuration = 300; // ms
    this.init();
  }
  return _createClass(SPANavigator, [{
    key: "init",
    value: function init() {
      var _this = this;
      // Intercept all navigation links
      this.setupLinkInterception();

      // Handle browser back/forward
      window.addEventListener('popstate', function (e) {
        return _this.handlePopState(e);
      });

      // Alpine.js integration
      if (window.Alpine) {
        this.setupAlpineIntegration();
      }
    }
  }, {
    key: "setupLinkInterception",
    value: function setupLinkInterception() {
      var _this2 = this;
      document.addEventListener('click', function (e) {
        var _link$getAttribute;
        var link = e.target.closest('a');
        if (!link) return;
        var href = link.getAttribute('href');
        var isExternal = link.getAttribute('target') === '_blank' || ((_link$getAttribute = link.getAttribute('rel')) === null || _link$getAttribute === void 0 ? void 0 : _link$getAttribute.includes('external'));
        var isAnchor = href === null || href === void 0 ? void 0 : href.startsWith('#');
        var isDownload = link.hasAttribute('download');

        // Skip external, anchor, download links, and non-HTTP(S) links
        if (isExternal || isAnchor || isDownload || !(href !== null && href !== void 0 && href.startsWith('/'))) {
          return;
        }

        // Skip login/logout/auth forms
        if (href.includes('login') || href.includes('register') || href.includes('logout') || href.includes('forgot-password')) {
          return;
        }
        e.preventDefault();
        _this2.navigateTo(href);
      });
    }
  }, {
    key: "setupAlpineIntegration",
    value: function setupAlpineIntegration() {
      var _this3 = this;
      // Expose to Alpine templates
      window.spa = {
        navigate: function navigate(url) {
          return _this3.navigateTo(url);
        },
        isLoading: function isLoading() {
          return _this3.isLoading;
        }
      };
    }
  }, {
    key: "navigateTo",
    value: function () {
      var _navigateTo = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(url) {
        var _window$Alpine, _window$Alpine2, response, html;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (!(this.isLoading || url === this.currentUrl)) {
                _context.next = 2;
                break;
              }
              return _context.abrupt("return");
            case 2:
              this.isLoading = true;
              _context.prev = 3;
              // Add loading indicator
              this.showLoadingState();

              // Fetch page content
              _context.next = 7;
              return fetch(url, {
                headers: {
                  'X-Requested-With': 'XMLHttpRequest',
                  'X-SPA-Request': 'true'
                }
              });
            case 7:
              response = _context.sent;
              if (response.ok) {
                _context.next = 10;
                break;
              }
              throw new Error("HTTP error! status: ".concat(response.status));
            case 10:
              _context.next = 12;
              return response.text();
            case 12:
              html = _context.sent;
              _context.next = 15;
              return this.transitionOut();
            case 15:
              // Update content
              this.updatePageContent(html);

              // Update URL
              window.history.pushState({
                url: url
              }, '', url);
              this.currentUrl = url;

              // Reinitialize Alpine components
              if ((_window$Alpine = window.Alpine) !== null && _window$Alpine !== void 0 && _window$Alpine.discardRoot) {
                window.Alpine.discardRoot(document.documentElement);
              } else if ((_window$Alpine2 = window.Alpine) !== null && _window$Alpine2 !== void 0 && _window$Alpine2.flushAndStopObserving) {
                window.Alpine.flushAndStopObserving();
              }

              // Fade in new content
              _context.next = 21;
              return this.transitionIn();
            case 21:
              // Scroll to top smoothly
              this.scrollToTop();

              // Dispatch custom event for other scripts
              window.dispatchEvent(new CustomEvent('spa:navigated', {
                detail: {
                  url: url,
                  html: html
                }
              }));
              _context.next = 29;
              break;
            case 25:
              _context.prev = 25;
              _context.t0 = _context["catch"](3);
              console.error('SPA Navigation Error:', _context.t0);
              // Fallback to full page reload
              window.location.href = url;
            case 29:
              _context.prev = 29;
              this.isLoading = false;
              this.hideLoadingState();
              return _context.finish(29);
            case 33:
            case "end":
              return _context.stop();
          }
        }, _callee, this, [[3, 25, 29, 33]]);
      }));
      function navigateTo(_x) {
        return _navigateTo.apply(this, arguments);
      }
      return navigateTo;
    }()
  }, {
    key: "updatePageContent",
    value: function updatePageContent(html) {
      var parser = new DOMParser();
      var doc = parser.parseFromString(html, 'text/html');

      // Extract and update content sections
      var newContent = doc.querySelector('#app-content');
      var currentContent = document.querySelector('#app-content');
      if (newContent && currentContent) {
        currentContent.innerHTML = newContent.innerHTML;
      }

      // Update page title if present
      var newTitle = doc.querySelector('title');
      if (newTitle) {
        document.title = newTitle.textContent;
      }

      // Update meta tags (og, description, etc)
      this.updateMetaTags(doc);

      // Reinitialize Alpine components in updated content
      this.reinitializeAlpine();
    }
  }, {
    key: "updateMetaTags",
    value: function updateMetaTags(doc) {
      var metaTags = doc.querySelectorAll('meta[property], meta[name]');
      metaTags.forEach(function (tag) {
        var existing = document.querySelector("meta[".concat(tag.hasAttribute('property') ? 'property' : 'name', "=\"").concat(tag.getAttribute('property') || tag.getAttribute('name'), "\"]"));
        if (existing) {
          existing.setAttribute('content', tag.getAttribute('content'));
        } else {
          document.head.appendChild(tag.cloneNode());
        }
      });
    }
  }, {
    key: "reinitializeAlpine",
    value: function reinitializeAlpine() {
      var _window$Alpine3;
      if ((_window$Alpine3 = window.Alpine) !== null && _window$Alpine3 !== void 0 && _window$Alpine3.data) {
        // Reinitialization happens automatically with Alpine.discardRoot
      }
    }
  }, {
    key: "handlePopState",
    value: function handlePopState(e) {
      var url = window.location.pathname;
      this.navigateTo(url);
    }
  }, {
    key: "showLoadingState",
    value: function showLoadingState() {
      var loader = document.getElementById('spa-loader');
      if (!loader) {
        loader = document.createElement('div');
        loader.id = 'spa-loader';
        loader.className = 'fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-400 to-blue-600 z-50 animate-pulse';
        document.body.appendChild(loader);
      }
      loader.classList.remove('hidden');
    }
  }, {
    key: "hideLoadingState",
    value: function hideLoadingState() {
      var loader = document.getElementById('spa-loader');
      if (loader) {
        setTimeout(function () {
          return loader.classList.add('hidden');
        }, 300);
      }
    }
  }, {
    key: "transitionOut",
    value: function () {
      var _transitionOut = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2() {
        var content;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              content = document.querySelector('#app-content');
              if (!content) {
                _context2.next = 6;
                break;
              }
              content.style.transition = "opacity ".concat(this.transitionDuration, "ms ease-out");
              content.style.opacity = '0';
              _context2.next = 6;
              return this.sleep(this.transitionDuration);
            case 6:
            case "end":
              return _context2.stop();
          }
        }, _callee2, this);
      }));
      function transitionOut() {
        return _transitionOut.apply(this, arguments);
      }
      return transitionOut;
    }()
  }, {
    key: "transitionIn",
    value: function () {
      var _transitionIn = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee3() {
        var content;
        return _regeneratorRuntime().wrap(function _callee3$(_context3) {
          while (1) switch (_context3.prev = _context3.next) {
            case 0:
              content = document.querySelector('#app-content');
              if (!content) {
                _context3.next = 9;
                break;
              }
              content.style.opacity = '0';
              content.offsetHeight; // Trigger reflow
              content.style.transition = "opacity ".concat(this.transitionDuration, "ms ease-in");
              content.style.opacity = '1';
              _context3.next = 8;
              return this.sleep(this.transitionDuration);
            case 8:
              content.style.transition = '';
            case 9:
            case "end":
              return _context3.stop();
          }
        }, _callee3, this);
      }));
      function transitionIn() {
        return _transitionIn.apply(this, arguments);
      }
      return transitionIn;
    }()
  }, {
    key: "scrollToTop",
    value: function scrollToTop() {
      var content = document.querySelector('#app-content');
      if (content) {
        content.scrollTop = 0;
      }
    }
  }, {
    key: "sleep",
    value: function sleep(ms) {
      return new Promise(function (resolve) {
        return setTimeout(resolve, ms);
      });
    }
  }]);
}(); // Initialize when DOM is ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', function () {
    window.spaNavigator = new SPANavigator();
  });
} else {
  window.spaNavigator = new SPANavigator();
}

/***/ })

}]);