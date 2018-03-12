<?php
namespace app\helper;

/** 
 * 业务配置类
 * @author nzw
 * @date 2018年02月08日 
 */
class Functions
{
     /**
     * html实体和字符串之间相互转化
     * @author: nzw
     * @date: 2017年8月31日
     * @param string $str | 待处理的字符串
     * @param bool $boolStrToHtml | 为true时是将字符串转化为html实体，为false时是将html实体转化为字符串
     */
    public static function strTransfer( $str, $boolStrToHtml = true )
    {
        $arrHtml = [ '&amp;', '&quot;', '&#39;', '&lt;', '&gt;', '&lt;', '&gt;', '&nbsp;' ];
        $arrStr = [ '&', '"', "'", '<', '>', '%3C', '%3E', ' ' ];

        if( $boolStrToHtml ){//由字符串转换为html实体
            $str = str_replace( $arrStr, $arrHtml, $str );
        }else{//由html实体转换为字符串
            $str = str_replace( $arrHtml, $arrStr, $str );
        }

        return $str;
    }

}
