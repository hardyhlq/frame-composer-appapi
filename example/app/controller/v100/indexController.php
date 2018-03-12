<?php

namespace app\controller\v100;

use ChelerApi\ChelerApi;
use ChelerApi\Controller;
use modules\BaseService\cms\DealerService;

/**
* @author hanliqiang
* @date 2018年2月7日
*/
class indexController extends Controller
{
    /**
     *
    * @author hanliqiang
    * @date 2018年3月06日
    */
    public function index()
    {
        $dealerid = "250774";
        $dealer = $this->_getDealerService()->getById($dealerid);

        $dealerRes = array(
            'username' => (string)$dealer['username'],
            'name' => (string)$dealer['name'],
            'addres' => (string)$dealer['addres'],
            'map' => (string)$dealer['map'],
            'tel' => (string)$dealer['tel2'],
            'tel1' => (string)$dealer['tel1'],
        );


//        $this->getMemcache("default")->set("a","asd");
//        print_r($this->getMemcache("default")->get("a"));exit;

//        $this->getRedis("default")->set("asd","123");
        
        $this->apiSuccess(200, '', $dealerRes);
    }

    /**
     * @return DealerService
     */
    private function _getDealerService()
    {
        return ChelerApi::getRPCService('cms.Dealer', 'b');
    }
}