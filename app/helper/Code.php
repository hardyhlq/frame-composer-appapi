<?php
namespace app\helper;
/** 
 * 机构code码类
 * @author lixin
 * @date 2017年6月23日 
 */
class Code {
    const CODE_SUCCESS = 200; //成功code码

    const CLIENT_ID_ERR = 1001; //client_id is error
    const TOKEN_ERR = 1003; //Token is something error

    //客户端错误
    const CODE_CLIENT_PARAM_ERR = 6101; //

    //服务端错误
    const CODE_SERVER_DATA_EMPTY = 6201; //数据库数据为空

    const CODE_PARAM_ERR = 1004; //参数错误code码
    const CODE_DEAL_FAIL_ERR = 1014; //处理失败
    
    /**
     * 默认成功code码
     */
    const SUCCESS = 200;
    
    /**
     * 默认失败code码
     */
    const FAIL = 104;
    
    /**
     * TOKEN不存在
     */
    const TOKEN_NOT_EXIST = 10401;
    
    /**
     * TOKEN错误
     */
    const TOKEN_ERROR = 10402;
    
    /**
     * TOKEN缓存数据错误
     */
    const TOKEN_CACHE_ERROR = 10403;
    
    /**
     * TOKEN过期
     */
    const TOKEN_EXPIRE = 10404;
}

