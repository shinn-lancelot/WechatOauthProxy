<?php

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $res['code'] = 0;
    $res['message'] = '登录失败！';

    $user = strip_tags(trim($_POST['user']));
    $password = $_POST['password'];
    if (empty($user)) {
        $res['message'] = '用户名不能为空！';
        echo json_encode($res);
        exit();
    }
    if (empty($password)) {
        $res['message'] = '密码不能为空！';
        echo json_encode($res);
        exit();
    }

    // 密码盐
    $salt = md5('shinn_lancelot');
    $res = json_decode(file_get_contents(__DIR__ . '/user.json'), true);
    $hasUser = false;
    foreach ($res as $key=>$value) {
        if ($value['user'] == $user) {
            $hasUser = true;
            if ($value['password'] == md5($password . $salt)) {
                // 生成用户登录令牌
                $token = getNonceStr();
                session_start();
                $_SESSION['token'] = $token;

                $res['code'] = 1;
                $res['message'] = '登录成功！';
            } else {
                $res['message'] = '密码错误！';
            }
            break;
        }
    }
    if (!$hasUser) {
        $res['message'] = '用户名不存在!';
    }

    echo json_encode($res);
}

/**
 * 获取随机字符串
 * @param int $length
 * @return string
 */
function getNonceStr($length = 16)
{
    $str2 = time();
    $length2 = strlen($str2);
    $length1 = $length - $length2;
    if($length1 <= 0){
        $length1 = 6;
    }

    $chars = "abcdefghijklmnopqrstuvwxyz";
    $str1 = "";
    for ( $i = 0; $i < $length1; $i++ )  {
        $str1 .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
    }
    $str = $str1.$str2;

    return $str;
}