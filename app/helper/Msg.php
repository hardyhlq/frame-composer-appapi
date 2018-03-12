<?php

namespace app\helper;

/**
 * 返回消息类
 * @author: nzw
 * @date: 2018年2月8日
 */
class Msg
{
    /**
     * 通用
     */
    CONST SUCCESS = '成功';
    CONST FAIL = '失败';
    CONST OPERATE_SUCCESS = '操作成功';
    CONST OPERATE_FAIL = '操作失败';
    CONST INSERT_SUCCESS = '添加成功';
    CONST INSERT_FAIL = '添加失败';
    CONST UPDATE_SUCCESS = '更新成功';
    CONST UPDATE_FAIL = '更新失败';
    CONST DELETE_SUCCESS = '删除成功';
    CONST DELETE_FAIL = '删除失败';
    CONST NO_DATA = '数据不存在';
    CONST PARAM_ERROR = '参数错误';
    CONST PARAM_TYPE_ERROR = '参数类型错误';
    CONST PARAM_LEN_ERROR = '参数长度错误';
    CONST PARAM_INT_LEN_ERROR = '参数整数部分长度错误';
    CONST PARAM_DEC_LEN_ERROR = '参数小数部分长度错误';
    CONST PARAM_NUMERIC = '参数应为数字类型';
    CONST PARAM_FLOAT = '参数应为浮点类型';
    CONST PARAM_UNSIGNED = '参数应为无符号类型';
    CONST PARAM_INT = '参数应为整型类型';

    CONST CLIENT_ID_ERR = 'client_id is error';
    CONST TOKEN_ERR = 'Token is something error';

}
?>