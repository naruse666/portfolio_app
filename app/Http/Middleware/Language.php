<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!array_intersect(['ja', 'ja-jp', 'en'], $request->getLanguages())){
            abort(402, 'we are supported English and Japanese');
        }

        return $next($request);
    }
}
