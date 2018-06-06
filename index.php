<?php

use wxOauthProxy\Wxoauth;

$code = $_GET['code'];
$oauthType = $_REQUEST['oauth_type'];
$scope = $_REQUEST['scope'];
$proxyScope = $_REQUEST['proxy_scope'];
$state = $_REQUEST['state'];

$appId = $_REQUEST['app_id'];
$appSecret = $_REQUEST['app_secret'];
$oauthType = $oauthType ? $oauthType : 1;
$state = $state ? $state : getNonceStr();
$scope = $scope ? $scope : 'snsnsapi_userinfo';
$proxyRedirectUri = getProtocol() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$proxyScope = $proxyScope ? $proxyScope : 1;    // 代理操作作用域， 1:仅获取code 2:获取用户openid或完整信息
$redirectUri = $_REQUEST['redirect_uri'];

$argArr = array(
    'appId'=>$appId,
    'appSecret'=>$appSecret,
    'oauthType'=>$oauthType,
    'state'=>$state,
    'scope'=>$scope,
    'proxyRedirectUri'=>$proxyRedirectUri,
    'proxyScope'=>$proxyScope
);

if(empty($code)){
    $wxOauth = new Wxoauth($argArr);
    $wxOauth::toGetCode();
}else if($proxyScope == 1){
    if(!empty($redirectUri)){
        header('Location:' . $redirectUri . '&code=' . $code . '&state=' . $state);
    }
}else if($proxyScope == 2){

}




function getProtocol() {
    return 'http';
}

function getNonceStr($length = 32) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for( $i = 0; $i < $length; $i++ ){
        $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    return $str;
}