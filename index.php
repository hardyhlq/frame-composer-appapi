<?php
/**
 * IndexController.php
 * 入口文件
 * Date: 18-2-5
 */

define('APP_PATH', __DIR__);

require_once __DIR__.'/vendor/autoload.php';

// 加载自定义配置文件
require('conf/conf.php');
\frame\ChelerApi::run();
