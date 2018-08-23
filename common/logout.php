<?php

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $res['code'] = 0;
    $res['message'] = '退出失败！';

    session_start();
    $token = $_SESSION['wop_admin_user'];
    if (!$token) {
        echo json_encode($res);
        exit();
    }

    $_SESSION['wop_admin_user'] = '';
    $res['code'] = 1;
    $res['message'] = '退出成功！';
    echo json_encode($res);
}