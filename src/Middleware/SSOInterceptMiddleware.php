<?php

namespace Mrlaozhou\SSO\Middleware;

use Closure;

class SSOInterceptMiddleware
{
    use \Mrlaozhou\SSO\Authenticate;

    /**
     * @param          $request
     * @param \Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     * @throws \throwable
     */
    public function handle($request, Closure $next)
    {
        if( !$this->user() && !$this->attemptLogin($request)  ) {
            //  清空本地登录信息
            //  $this->localLogout();
            //  跳转授权端
            return $this->redirectToSSOServer();
        }
        //  刷新票有效期
        //  $this->refreshRemoteTicketExpire();
        return $next($request);
    }
}
