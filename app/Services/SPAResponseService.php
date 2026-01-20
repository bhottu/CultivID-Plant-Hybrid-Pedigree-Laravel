<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\View\View;

class SPAResponseService
{
    /**
     * Handle SPA page transitions
     * 
     * Returns only the content for AJAX requests,
     * returns full page for regular requests
     * 
     * @param string|View $view The view name or View instance
     * @param array $data Data to pass to the view
     * @param int $status HTTP status code
     * @return \Illuminate\Http\Response|View
     */
    public static function render($view, $data = [], $status = 200)
    {
        // Check if this is an SPA request
        $isSPARequest = request()->header('X-SPA-Request') === 'true';
        
        if ($isSPARequest) {
            // For SPA requests, render only the content section
            return response(
                view($view, $data)->renderSection('content'),
                $status
            )->header('X-SPA-Response', 'true');
        }
        
        // For normal requests, return full view
        return view($view, $data);
    }

    /**
     * Check if current request is SPA navigation
     */
    public static function isSPARequest(): bool
    {
        return request()->header('X-SPA-Request') === 'true' || 
               request()->header('X-Requested-With') === 'XMLHttpRequest';
    }

    /**
     * Get partial content for quick updates without full navigation
     * Used for infinite scroll, pagination, etc.
     * 
     * @param string $view View name
     * @param array $data Data to pass to view
     * @param string|null $section Blade section to render (default: 'content')
     * @return \Illuminate\Http\Response
     */
    public static function partial($view, $data = [], $section = 'content')
    {
        return response(
            view($view, $data)->renderSection($section)
        )->header('X-SPA-Partial', 'true');
    }
}
