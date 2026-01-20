<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleSPARequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if this is a SPA request (AJAX navigation)
        $isSPARequest = $request->header('X-SPA-Request') === 'true' || 
                       $request->header('X-Requested-With') === 'XMLHttpRequest';

        // Store in request for use in views
        $request->attributes->set('spa_request', $isSPARequest);

        $response = $next($request);

        // If SPA request, set appropriate headers
        if ($isSPARequest) {
            $response->header('X-SPA-Response', 'true');
        }

        return $response;
    }
}
