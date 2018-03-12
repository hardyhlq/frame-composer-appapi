<?php
namespace app\helper;

use frame\ChelerApi;
use frame\runtime\CRequest;

class BaseApiController extends \frame\runtime\Controller { 
	
	public $access_token;
	
	/**
	 * APP接口前置入口权限判断
	 */	
	public function before() {
	    $client_id = isset(CRequest::$_GET['client_id']) ? CRequest::$_GET['client_id'] : '';

        //约定KEY
	    if(empty($client_id) || $client_id != API_KEY){
	        $this->apiError(Code::CLIENT_ID_ERR, Msg::CLIENT_ID_ERR);
	    }

	    //全局变量注册
	    //全局Controller使用方式：$this->authorize
        $authorize['client_id'] = $client_id;
        $authorize['token'] = isset(CRequest::$_GET['token']) ? CRequest::$_GET['token'] : '';
	    $this->register_global('authorize', $authorize);
	}
	
	/**
	 * 用户登陆授权验证
	 */
	protected function authorizeToken(){
		$authorize = $this->authorize;
		$token = $authorize['token'];
		$testMsg['before'] = $token;
		$token = hashCode($token);
		$testMsg['after'] = $token;
		if(empty($token)){
			$this->apiError(Code::TOKEN_ERR, Msg::TOKEN_ERR);
		}
		
		$decodeToken = explode('_', $token);
		$uid = intval($decodeToken[0]);
		$mobile = $decodeToken[2];
		$oauth = $decodeToken[3];
		$testMsg['token'] = $decodeToken;
		if($uid < 1 || !$this->controller->is_mobile($mobile) || empty($oauth)){
            $this->apiError(Code::TOKEN_ERR, Msg::TOKEN_ERR, $testMsg);
		}
		
//		/*授权验证 -- begin*/
//		$member_arr = $this->_getMemberService()->getUserInfo($uid);
//
//		if($member_arr['id'] != $uid){
//            $this->apiError(Code::TOKEN_ERR, Msg::TOKEN_ERR);
//		}
//
//		if($oauth != $member_arr['loginoauth']){
//			$this->apiError(1002, '啊哦~~被踢了~您的账户已在其他手机上登录');
//		}
//		/*授权验证 -- begin*/
//
//		$userInfo = $member_arr;
//		$userInfo['uid'] = $uid;
//		$this->register_global('userInfo', $userInfo);
		
		//用户登录后变更authorize
		$authorize = $this->authorize;
		$this->register_global('authorize', $authorize);
	}
	
	/**
	 * TOKEN解密获取UID[用于获取用户UID]
	 * @author lxm
	 */
	protected function decodeToken(){
		$authorize = $this->authorize;
		$token = $authorize['token'];
		$token = hashCode($token);
		$decodeToken = explode('_', $token);
		$uid = intval($decodeToken[0]);
		$mobile = $decodeToken[2];
		$oauth = $decodeToken[3];
		/*授权解密信息*/
		$userInfo = array(
				'uid'=>$uid,
				'mobile'=>$mobile,
				'oauth'=>$oauth
		);
		$this->register_global('userInfo', $userInfo);
	}
	
    /**
     * @return MemberService
     */
    private function _getMemberService() {
        return ChelerApi::getService('clw2\member');
    }
}
