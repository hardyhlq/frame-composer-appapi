<?php

namespace app\controller\v1\demo;

use app\helper\BaseApiController;
use app\service\demo\DemoService;
use frame\ChelerApi;
use app\helper\Code;

/**
* @author hanliqiang
* @date 2018年2月7日
*/
class IndexController extends BaseApiController
{
    /**
     *
    * @author hanliqiang
    * @date 2018年3月06日
    */
    function index()
    {
        $res = $this->_getDemoService()->getUserInfo();
        $this->apiSuccess(Code::CODE_SUCCESS, '', $res);
    }

    /**
     * @return DemoService
     */
    private function _getDemoService()
    {
        return ChelerApi::getService('demo\Demo');
    }
}