<?php

function var_json($info = '', $code = 10000, $data = array(), $location = '') {

    $out['code'] = $code ?: 0;

    $out['info'] = $info ?: ($out['code'] ? 'error' : 'success');

    $out['data'] = $data ?: array();

    $out['location'] = $location;

    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($out, JSON_HEX_TAG);

    exit(0);

}

$a = empty($_GET['a']) ? '' : $_GET['a'];
$qq = empty($_GET['qq']) ? 0 : intval($_GET['qq']);

$data = array();
$data[979136] = array('qq'=>979136, 'vip'=>5,'level'=>128, 'reg_time'=>1376523234, 'qb'=>300);
$data[979137] = array('qq'=>979137, 'vip'=>8,'level'=>101, 'reg_time'=>1377123144, 'qb'=>300);

preg_match('/^[a-zA-Z]+$/', $a) || var_json('非法调用');
isset($data[$qq]) || var_json('用户不存在', 100001);

switch ($a) {
    //获取用户基本信息
    case 'info': 
        //你的更多业务逻辑 ...
        var_json('success', 0, $data[$qq]);
        break;
    //获取动态消息
    case 'message':
        var_json('您正在调用动态消息接口', 0);
        break;
    //获取好友列表
    case 'friends':
        var_json('你正在调用好友列表接口', 0);
        break;
    default:
        var_json('非法调用');
}
