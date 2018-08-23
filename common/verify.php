<?php

if (strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $res['code'] = 0;
    $res['message'] = '提交失败！';

    $filePrefix = 'MP_verify_';
    $callBackUrl = $_SERVER['HTTP_HOST'];

    $txt = strip_tags(trim($_POST['txt']));

    if (empty($txt)) {
        echo json_encode($res);
        exit();
    }

    file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/' . $filePrefix . $txt . '.txt' , $txt);
    $res['code'] = 1;
    $res['message'] = '提交成功！';
    $res['data'] = array(
        'callBackUrl'=>$callBackUrl
    );
    echo json_encode($res);
}