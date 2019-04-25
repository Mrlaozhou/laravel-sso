## Install
```php
composer require mrlaozhou/laravel-sso
```

## Doc
#### Middleware
`sso.intercept` => `\Mrlaozhou\SSO\Middleware\SSOInterceptMiddleware::class`

请求拦截, 保护路由、自动处理

`sso.refresh` => `\Mrlaozhou\SSO\Middleware\SSORefreshTokenExpireMiddleware::class`

刷新ticket有效期

## Description

- 用户访问受保护路由(middleware => sso.intercept)
	+ 已授权 
		*	通过
		*	刷新票有效期(同步退出)
	+ 未授权 
		*	携带证书
		*	跳转授权服务端
	
