<?php
namespace Mrlaozhou\SSO\Concerns;

use Illuminate\Support\Facades\Auth;

trait LocalGuard
{

    protected static $localTicketSessionKey     =   'sso_ticket';

    /**
     * 本地是的否登录
     *
     * @return mixed
     */
    public function localHadAuthorized()
    {
        //  本地是否登录 && 是否有ticket
        return request()->user();
    }

    /**
     * 本地登录
     * @param $openID
     * @param $ticket
     *
     * @return bool
     */
    public function localLoginByOpenID($openID, $ticket = null)
    {
        //  $this->rememberLocalTicket( $ticket );
        return Auth::loginUsingId( $openID );
    }

    /**
     * 本地登出
     */
    public function localLogout()
    {
        Auth::logout();
    }

    /**
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    protected function getLocalTicket()
    {
        return $this->localGuard()->get( static::$localTicketSessionKey );
    }

    /**
     * @param $ticket
     *
     * @return \Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    protected function rememberLocalTicket($ticket)
    {
        return $this->localGuard()->put( static::$localTicketSessionKey, $ticket );
    }

    /**
     * @return mixed
     */
    protected function destroyLocalTicket()
    {
        return $this->localGuard()->forget(static::$localTicketSessionKey);
    }
}