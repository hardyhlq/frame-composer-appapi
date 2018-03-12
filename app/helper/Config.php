<?php
namespace app\helper;

/** 
 * 业务配置类
 * @author nzw
 * @date 2018年02月08日 
 */
class Config
{
    /**
     * CARLT_OA加密前缀
     */
    CONST PREFIX = 'CARLTOA_';
    
    /**
     * token过期时间（单位：s）
     */
    CONST TOKEN_EXPIRE_SECONDS = 86400;
    
    /**
     * 字符串最大默认长度
     */
    CONST PARAM_MAX_LENGTH = 20;
    
    /**
     * 密码最大长度
     */
    CONST PWD_LEN_MAX = 16;
    
    /**
     * 密码最小长度
     */
    CONST PWD_LEN_MIN = 6;
    
    /**
     * 用户原始密码
     */
    CONST PWD_USER_ORIGINAL = '123456';
    
    /**
     * 密码salt长度
     */
    CONST PWD_SALT_LEN = 6;

    /**
     * 分页默认限制
     */
    CONST LIMIT = 20;

    /**
     * 分页偏移量
     */
    CONST OFFSET = 0;

}
