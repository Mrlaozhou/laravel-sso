<?php
namespace Mrlaozhou\SSO\Concerns;

use Mrlaozhou\SSO\Exceptions\SSOException;

trait RemoteGuard
{
    protected static $ticketPrefix              =   'tickets_';

    /**
     * 远程是否登录
     * @return mixed
     */
    public function remoteHadAuthorized()
    {
        return $this->ssoRedisClient()->get($this->getLocalTicket());
    }

    /**
     * @return int
     */
    public function remoteLogout()
    {
        return $this->destroyRemoteTicket();
    }

    /**
     * 获取OPENID
     * @param null $ticket
     *
     * @return mixed
     * @throws \throwable
     */
    public function getRemoteOpenId($ticket=null)
    {
        if( $token = $this->ssoRedisClient()->get( $ticket ?: $this->getLocalTicket() ) ) {
            return $token;
        }
        throw new SSOException('TOKEN不合法或已过期');
    }

    /**
     * 补全远程ticket
     *
     * @param $ticket
     * @return string
     */
    protected function fillTicket($ticket)
    {
        return static::$ticketPrefix . $ticket;
    }

    /**
     * @param null $ticket
     *
     * @return int
     */
    public function refreshRemoteTicketExpire($ticket = null)
    {
        return $this->ssoRedisClient()->expire(
            $ticket ? $this->fillTicket($ticket) : $this->getLocalTicket(),
            config('sso.expire')
        );
    }

    /**
     * @return int
     */
    public function destroyRemoteTicket()
    {
        return $this->ssoRedisClient()->del([$this->getLocalTicket()]);
    }
}