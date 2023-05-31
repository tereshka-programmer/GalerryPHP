<?php

namespace App\Http\Middleware;

use App\Enum\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = ''): Response
    {
        if (auth()->check() && auth()->user()->admin()) {
            $maxAttempts = 'admin';
        } elseif (auth()->check() && auth()->user()->author()) {
            $maxAttempts = 'author';
        } else {
            $maxAttempts = 'guest';
        }

        $limiter = $this->limiter->limiter($maxAttempts);
        return $this->handleRequestUsingNamedLimiter($request, $next, $maxAttempts, $limiter);
    }
}
