<?php

use WechatOauthProxy\WechatOauth;
require __DIR__ . 'WechatOauthProxy/WechatOauth.php';

$code = $_GET['code'];
$proxyScope = $_REQUEST['proxy_scope'];
$proxyScope = $proxyScope ? $proxyScope : 1;    // 代理操作作用域，默认仅获取code 1:仅获取code 2:获取用户openid或完整信息
$state = $_REQUEST['state'];
$state = $state ? $state : getNonceStr();

// 有code且代理作用域为1（仅获取code），直接跳转回请求源
if(!empty($code) && $proxyScope == 1){
    $redirectUri = $_COOKIE['redirect_uri'];
    if(!empty($redirectUri)){
        header('Location:' . $redirectUri . '&code=' . $code . '&state=' . $state);
    }else{
        exit();
    }
}

$appId = $_REQUEST['app_id'];
$appSecret = $_REQUEST['app_secret'];
$oauthType = $_REQUEST['oauth_type'];
$oauthType = $oauthType ? $oauthType : 1;   //授权类型，默认公众号授权 1:公众号授权 2:开放平台网页授权
$scope = $_REQUEST['scope'];
$scope = $scope ? $scope : 'snsnsapi_userinfo';

$protocol = isHttps() ? 'https' : 'http';
$requestUri = $proxyScope == 2 ? '/'.http_build_query(array('appid'=>$appId,'secret'=>$appSecret)) : '';
$proxyRedirectUri = $protocol . '://' . $_SERVER['HTTP_HOST'] . $requestUri;
$redirectUri = $_REQUEST['redirect_uri'];

if(empty($code)){
    setCookie('redirect_uri', $redirectUri, 300);
    $paramsArr = array(
        'appid'=>$appId,
        'redirect_uri'=>$proxyRedirectUri,
        'response_type'=>'code',
        'scope'=>$scope,
        'state'=>$state
    );
    WechatOauth::toGetCode($paramsArr, $oauthType);
    
}else if($proxyScope == 2){
    // 进一步获取用户信息
}


/**
 * 通用函数
 */
function isHttps() {
    if(!isset($_SERVER['HTTPS']))  return false;
    if($_SERVER['HTTPS'] === 1){  //Apache
        return true;
    }elseif($_SERVER['HTTPS'] === 'on'){ //IIS
        return true;
    }elseif($_SERVER['SERVER_PORT'] == 443){ //其他
        return true;
    }
    return false;
}

function getNonceStr($length = 32) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for( $i = 0; $i < $length; $i++ ){
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}