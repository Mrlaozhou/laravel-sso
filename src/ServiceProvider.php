<?php
namespace Mrlaozhou\SSO;

use Illuminate\Support\Facades\Route;
use \Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Mrlaozhou\SSO\Middleware\SSOInterceptMiddleware;
use Mrlaozhou\SSO\Middleware\SSORefreshTokenExpireMiddleware;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        //  合并配置文件
        $this->mergeConfigFrom( $config_path = __DIR__ . '/../config/laravel-sso.php', 'laravel-sso' );
        //  注册路由中间件别名
        $this->registerRouteMiddlewareAlias();
    }

    protected function registerRouteMiddlewareAlias()
    {
        $this->app['router']->aliasMiddleware('sso.intercept', SSOInterceptMiddleware::class);
        $this->app['router']->aliasMiddleware('sso.refresh', SSORefreshTokenExpireMiddleware::class);
    }
}