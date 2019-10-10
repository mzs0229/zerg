<?php
return [
    'app_id' => 'wx669eaba828eed0e1',
    // 小程序app_secret
    'app_secret' => 'd855ba478c6c9cc2456b1f71f0c7861a',

    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?"."appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?"."grant_type=client_credential&appid=%s&secret=%s",
];

