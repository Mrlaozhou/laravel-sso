<?php
namespace Mrlaozhou\SSO\Contracts;

interface SSOClientAuthorizeHandle
{

    /**
     * @param      $openID
     * @param null $ticket
     *
     * @return bool
     */
    public function authorize($openID, $ticket = null);
}