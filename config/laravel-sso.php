<?php

return [
    /*
    |--------------------------------------------------------------------------
    | -- 配置 --
    |--------------------------------------------------------------------------
    |   -- 描述 --
    |
    */

    //  是否保持同步
    'keepRemoteSync'                =>  false,

    //  服务端接收客户端证书参数名称
    'certificateKeyName'            =>  'certificate',

    //  返回客户端的tokenName
    'tokenName'                     =>  'token',

    //  passport授权端URL地址
    'passportUrl'                   =>  'https://passport.net-japan.cn/authorize',
];