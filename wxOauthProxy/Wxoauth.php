<?php

namespace wxOauthProxy;

class Wxoauth {
    private static $appId = ''; // 公众号appid
    private static $appSecret = ''; // 公众号appsecret
    private static $oauthType = '';  // 授权类型，默认公众号授权登录 1:公众号授权登录 2:微信网页第三方登录
    private static $state = ''; // 授权重定向参数
    private static $scope = ''; //授权作用域，snsapi_base|snsapi_userinfo
    private static $proxyRedirectUri = '';   // 代理操作的uri

    public function __construct($argArr = array()) {
        static::$appId = $argArr['appId'];
        static::$appSecret = $argArr['appSecret'];
        static::$oauthType = $argArr['oauthType'];
        static::$state = $argArr['state'];
        static::$scope = $argArr['scope'];
        static::$proxyRedirectUri = $argArr['proxyRedirectUri'];
    }

    // 获取code
    public static function toGetCode() {
        $codeUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?';
        if(static::$oauthType == 2) {
            $codeUrl = 'https://open.weixin.qq.com/connect/qrconnect?';
        }

        $paramsArr = array(
            'appid'=>static::$appId,
            'redirect_uri'=>urlencode(static::$proxtRedirectUri),
            'response_type'=>'code',
            'scope'=>static::$scope,
            'state'=>static::$state
        );

        $requestUrl = $codeUrl . http_build_query($paramsArr);
        header('Location:' . $requestUrl);
    }
}