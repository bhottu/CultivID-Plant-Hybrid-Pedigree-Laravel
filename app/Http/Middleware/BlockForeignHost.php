<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockForeignHost
{
   public function handle($request, Closure $next)
    {
        $allowed = [
            'cultiv.id',
            'www.cultiv.id',
            'localhost',
            '127.0.0.1'
            
        ];

        if (!in_array($request->getHost(), $allowed)) {
            return response()->view('blocked-domain');
        }

        return $next($request);
    }
}