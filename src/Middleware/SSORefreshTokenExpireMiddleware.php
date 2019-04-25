<?php

namespace Mrlaozhou\SSO\Middleware;

use Closure;

class SSORefreshTokenExpireMiddleware
{
    use \Mrlaozhou\SSO\Authenticate;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( $this->user() ) {
            $this->refreshRemoteTicketExpire();
        } else {
            $this->localLogout();
        }
        return $next($request);
    }
}
