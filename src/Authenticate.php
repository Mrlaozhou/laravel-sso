<?php
namespace Mrlaozhou\SSO;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Mrlaozhou\Indulge\Exceptions\Exception;
use Mrlaozhou\SSO\Exceptions\SSOException;
use Mrlaozhou\Yar\Client;
use Mrlaozhou\Yc\Yc;

trait Authenticate
{
    use Concerns\LocalGuard,
        Concerns\RemoteGuard;

    /**
     * 是否是完整登录状态
     *
     * @return bool
     */
    public function user()
    {
        if( $this->localHadAuthorized() ) {
            return true;
        }
        return false;
    }

    /**
     * 尝试授权
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     * @throws \throwable
     */
    public function attemptLogin(Request $request)
    {
        try{
            //  获取载荷信息
            $payload = $this->getPayloadFromToken();
            //  是否同步远程
            if( config('laravel-sso.keepRemoteSync', false) ) {
                $openid = $this->getRemoteOpenId( $ticket = $this->fillTicket($ticket = $payload['ticket']) );
            } else {
                $openid = $payload['openID'];
            }
            //  授权
            if( config('laravel-sso.customAuthorizeHandler') ) {

            }
            if( $this->localLoginByOpenID($openid) ) {
                //  刷新ticket有效期
//                $this->refreshRemoteTicketExpire();
                //  刷新页面
                return true;
            }
        }catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function ssoLogout()
    {
        $this->remoteLogout();
        $this->localLogout();
    }

    /**
     * 跳转到授权服务端
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToSSOServer()
    {
        $passportUrl            =   config('laravel-sso.passportUrl') . "?"
                                    . config('laravel-sso.certificateKeyName') . '='
                                    . $this->buildAuthorizationCertificate();
        return redirect($passportUrl);
    }

    /**
     * 获取payload
     * @return bool|array
     * @throws \throwable
     */
    protected function getPayloadFromToken()
    {
        if( ($token = $this->token()) && ($payload = $this->jwtServerProvider()->parseToken($token)) ) {
            return $payload['SID'] === session()->getId() ?   $payload :   false;
        }
        throw new SSOException('TOKEN不合法');
    }

    /**
     * 构建授权凭证
     *
     * @return string
     */
    protected function buildAuthorizationCertificate()
    {
        return $this->jwtServerProvider()->touch('createToken', [
            'URL'               =>  \request()->url(),
            'ID'                =>  '',
            'SECRET'            =>  '',
            'SID'               =>  session()->getId(),
        ]);
    }

    /**
     * @return string|bool
     */
    protected function token()
    {
        return \request(config('laravel-sso.tokenName'), false);
    }

    /**
     * sso存储的redis客户端
     *
     * @return \Illuminate\Redis\Connections\Connection
     */
    protected function ssoRedisClient()
    {
        return Redis::connection('sso');
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    protected function localGuard()
    {
        return session();
    }

    /**
     * @return \Mrlaozhou\Yar\Client
     */
    public function jwtServerProvider()
    {
        return new Client( Yc::get('macro.wheel.domain') . Yc::get('macro.wheel.server.jwt') );
    }
}