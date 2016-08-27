<?php
// vim: set expandtab cindent tabstop=4 shiftwidth=4 fdm=marker:
// +----------------------------------------------------------------------+
// | The Code Inc                                                  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2013, Code Inc. All rights reserved.            |
// +----------------------------------------------------------------------+
// | Authors: The PHP Dev Team, ISRD, Code Inc.                    |
// |                                                                      |
// +----------------------------------------------------------------------+

\think\Route::get('geetest/[:id]', "\\think\\geetest\\GeetestController@index");
/**
 *
 * @return bool
 */
function geetest($config = [])
{
    $config = empty($config) ? \think\Config::get('geetest') : $config;
    $geetest = new \think\geetest\GeetestLib($config);
    \think\Session::set('gt_user_id', $_SERVER['REQUEST_TIME']);
    \think\Session::set('gt_server_status', $geetest->pre_process(\think\Session::get('gt_user_id')));
    return $geetest->get_response_str();
}
/**
 * @return string
 */
function geetest_url()
{
    return \think\Url::build('/geetest');
}
/**
 *
 * @return bool
 */
/**
 * 极验验证
 * @param array $post post提交的数据
 * @param array $config
 * @return bool
 */
function geetest_check($post, $config = [])
{
    $config = empty($config) ? \think\Config::get('geetest') : $config;
    $geetest = new \think\geetest\GeetestLib($config);
    if (1 == \think\Session::get('gt_server_status')) {
        if ($geetest->success_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode'], \think\Session::get('gt_user_id'))) {
            return true;
        } else {
            return false;
        }
    } else {
        if ($geetest->fail_validate($post['geetest_challenge'], $post['geetest_validate'], $post['geetest_seccode'])) {
            return true;
        } else {
            return false;
        }
    }
}
