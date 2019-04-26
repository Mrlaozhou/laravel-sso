<?php
namespace Mrlaozhou\SSO;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

abstract class UserGuardProvider extends Authenticatable
{
    use Notifiable;

    public $incrementing            =   false;

    protected $primaryKey           =   'openid';

    protected $keyType              =   'string';

    protected $guarded              =   [
        'status', 'sinaopenid', 'qqopenid', 'wxopenid', 'alipayopenid'
    ];

    protected $hidden               =   [
        'user_id', 'password', 'register_appid', 'status', 'sinaopenid'
        , 'qqopenid', 'wxopenid', 'alipayopenid', 'remember_token'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function withProfile()
    {
        return $this->hasOne(UsersProfile::class, 'user_id', 'user_id');
    }

    /**
     * @return \Mrlaozhou\SSO\UsersProfile|null
     */
    public function profile()
    {
        return $this->withProfile;
    }

    /**
     * @return  null|int
     */
    public function userID()
    {
        return $this->user_id;
    }

    /**
     * @return null|int
     */
    public function openID()
    {
        return $this->openid;
    }

    /**
     * @return string
     */
    public function completeMobile()
    {
        return $this->c_code . $this->mobile;
    }
}