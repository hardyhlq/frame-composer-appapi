<?php
/* 框架全局配置常量 */
error_reporting(E_ALL);

/* 框架全局配置变量 */
/*********************************基础配置*****************************************/
// 站点URL配置
$_CONFIG_['url']['url'] = 'http://capi.com/';
$_CONFIG_['url']['clw'] = 'http://test.linewin.cc/';
$_CONFIG_['url']['image'] = 'http://timage.linewin.cc/';
$_CONFIG_['url']['default_bucket'] = 'www-linewin-cc';
$_CONFIG_['url']['ossimage'] = 'http://ossimage.linewin.cc/';

// 是否开启调试
$_CONFIG_['debug'] = true;

/**
 * 路由访问方式
 * 2. default：index.php?_v=1&m=user&c=index&a=run
 * 3. rewrite：/1/user/index/run?id=100
 */
$_CONFIG_['uriType'] = 'rewrite';

// rpc配置
$_CONFIG_['rpc']['address'] = 'http://127.0.0.1:8282/';
$_CONFIG_['rpc']['timeout'] = 10;

/*********************************Controller配置*****************************************/
/**
 * Controller控制器配置参数
 * 1. 你可以配置控制器默认的文件夹，默认的后缀，Action默认后缀，默认执行的Action和Controller
 * 2. 一般情况下，你可以不需要修改该配置参数
 * 3. $_CONFIG_['ismodule']参数，当你的项目比较大的时候，可以选用module方式，
 * 开启module后，你的URL种需要带m的参数，原始：index.php?c=index&a=run, 加module：
 * index.php?m=user&c=index&a=run , module就是$_CONFIG_['controller']['path']目录下的
 * 一个文件夹名称，请用小写文件夹名称
 */
$_CONFIG_['ismodule'] = false; //开启module方式
$_CONFIG_['controller']['path']                  = 'controller/';
$_CONFIG_['controller']['controller_postfix']    = 'Controller'; //控制器文件后缀名
$_CONFIG_['controller']['action_postfix']        = ''; //Action函数名称后缀
$_CONFIG_['controller']['default_controller']    = 'index'; //默认执行的控制器名称
$_CONFIG_['controller']['default_action']        = 'run'; //默认执行的Action函数
$_CONFIG_['controller']['module_list']           = array('test', 'index'); //module白名单
$_CONFIG_['controller']['default_module']        = 'index'; //默认执行module
$_CONFIG_['controller']['default_before_action'] = 'before'; //默认前置的ACTION名称
$_CONFIG_['controller']['default_after_action']  = 'after'; //默认后置ACTION名称


//mongo
$_CONFIG_['mongo']['group']['username']   = '';
$_CONFIG_['mongo']['group']['password']   = '';
$_CONFIG_['mongo']['group']['server']     = '121.40.133.157';
$_CONFIG_['mongo']['group']['port']       = '27017';
$_CONFIG_['mongo']['group']['verify']     = '';
$_CONFIG_['mongo']['log']['server']     = '121.40.133.157';
$_CONFIG_['mongo']['log']['port']       = '27017';

/*********************************Memcache缓存配置*****************************************/
/**
 * 缓存配置参数
 * 1. 您如果使用缓存 需要配置memcache的服务器和文件缓存的缓存路径
 * 2. memcache可以配置分布式服务器，根据$_CONFIG_['memcache'][0]的KEY值去进行添加
 * 3. 根据您的实际情况配置
 */
$_CONFIG_['memcache']['default']['server']   = '127.0.0.1';
$_CONFIG_['memcache']['default']['port']   = '11211';


/**
 * Redis配置，如果您使用了redis，则需要配置
 */
//缓存
$_CONFIG_['redis']['default']['host']       = '127.0.0.1';
$_CONFIG_['redis']['default']['port']       = '6379';
$_CONFIG_['redis']['default']['password']   = '123456';
$_CONFIG_['redis']['default']['db']         = 0;

//push
$_CONFIG_['redis']['push']['host']       = '127.0.0.1';
$_CONFIG_['redis']['push']['port']       = '6379';
$_CONFIG_['redis']['push']['password']   = '';
$_CONFIG_['redis']['push']['db']         = 1;

//geo redis
$_CONFIG_['redis']['geo']['host']       = '127.0.0.1';
$_CONFIG_['redis']['geo']['port']       = '6379';
$_CONFIG_['redis']['geo']['password']   = '';
$_CONFIG_['redis']['geo']['db']         = 2;

/********************************* 其他扩展配置 ********************************************/
//接口KEY
define('API_KEY', '0896756ebec5bc62a51b15b9a7541901');

// 加载自定义版本配置
require('conf/version.conf.php');
