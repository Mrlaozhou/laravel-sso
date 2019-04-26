<?php
namespace Mrlaozhou\SSO;

use Illuminate\Database\Eloquent\Model;

class UsersProfile extends Model
{
    //
    public $incrementing        =   false;

    protected $table            =   'users_profile';

    protected $hidden           =   [
        'address', 'last_login_ip', 'last_login_time', 'last_login_appid'
    ];

    protected $primaryKey       =   'user_id';

    protected $guarded          =   [

    ];
}