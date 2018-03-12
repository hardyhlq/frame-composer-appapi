<?php
/**
 * api.conf.php
 * 接口配置文件
 * Date: 17-12-12
 */
global $_CONFIG_;
$_CONFIG_['apiConfig'] = [
    // 一个项目配置一个
    'dingdingApi' => [
        // 校验方式是否开启
        'authSwitch' => false,
        // 超时 单位秒
        'timeout' => 60,
        // 本地域名
        'domainLocal' => 'https://oapi.dingtalk.com',
        // 测试域名
        'domainDev' => 'https://oapi.dingtalk.com',
        // 预发布域名
        'domainPre' => 'https://oapi.dingtalk.com',
        // 正式域名
        'domainProduct' => 'https://oapi.dingtalk.com',
        // 接口配置
        'api' => [
            'gettoken' => [ //获取企业授权的access_token
                'method' => 'GET',
                'name' => '/gettoken',
            ],
            'department_list' => [ //获取部门列表
                'method' => 'GET',
                'name' => '/department/list',
            ],
            'department_get' => [ //获取部门详情
                'method' => 'GET',
                'name' => '/department/get',
            ],
            
            'user_list' => [ //获取部门成员详情
                'method' => 'GET',
                'name' => '/user/list',
            ],
            'user_get' => [ //获取成员详情
                'method' => 'GET',
                'name' => '/user/get',
            ],
            'sns_gettoken' => [ //获取钉钉开放应用的ACCESS_TOKEN
                'method' => 'GET',
                'name' => '/sns/gettoken',
            ],
            'sns_get_persistent_code' => [ //获取用户授权的持久授权码
                'method' => 'POST',
                'name' => '/sns/get_persistent_code',
            ],
            'sns_get_sns_token' => [ //获取用户授权的SNS_TOKEN
                'method' => 'POST',
                'name' => '/sns/get_sns_token',
            ],
            'sns_getuserinfo' => [ //获取用户授权的个人信息
                'method' => 'GET',
                'name' => '/sns/getuserinfo',
            ],
        ],
    ],

];