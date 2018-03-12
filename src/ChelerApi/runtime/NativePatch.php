<?php

/**
 * 通用的方法
 * @author lonphy
 */

/**
 * 判断是否是关联数组
 *
 * @param mixed $value            
 * @return boolean
 */
function is_assoc($value)
{
    return array_keys($value) !== range(0, count($value) - 1);
}

/**
 * 加密/解密函数 用于cookie 等
 * hash_code(10000, 'ENCODE');//加密 hash_code($auth_hash);//解密
 *
 * @param string $string
 *            加密/解密字符
 * @param string $operation
 *            ENCODE=加密 DECODE=解密
 * @param string $key
 *            加密KEY
 * @param int $expiry            
 * @return string
 */
function hashCode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
    $string = str_replace('x2013x', '+', $string);
    $ckey_length = 6;
    $key = md5($key != '' ? $key : HASHKEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), - $ckey_length)) : '';
    
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    
    $result = '';
    $box = range(0, 255);
    
    $rndkey = array();
    for ($i = 0; $i <= 255; $i ++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    
    for ($j = $i = 0; $i < 256; $i ++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    
    for ($a = $j = $i = 0; $i < $string_length; $i ++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace(array(
            '=',
            '+'
        ), array(
            '',
            'x2013x'
        ), base64_encode($result));
    }
}
/**
 * 验证身份证号
 * @param string $vStr
 * @return bool
 */
function isCreditNo($vStr)
{
    $len = strlen($vStr);
    if($len < 1) return false;
    if($len == 8) {
        return check_hkid($vStr);
    }
    else {
        return check_chinaid($vStr);
    }
}

//中国ID验证
function check_chinaid($vStr)
{
    $vCity = array(
        '11','12','13','14','15','21','22',
        '23','31','32','33','34','35','36',
        '37','41','42','43','44','45','46',
        '50','51','52','53','54','61','62',
        '63','64','65','71','81','82','91'
    );
    
    if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
    
    if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
    
    $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
    $vLength = strlen($vStr);
    
    if ($vLength == 18)
    {
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
    } else {
        $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
    }
    
    if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
    if ($vLength == 18)
    {
        $vSum = 0;
        
        for ($i = 17 ; $i >= 0 ; $i--)
        {
            $vSubStr = substr($vStr, 17 - $i, 1);
            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
        }
        
        if($vSum % 11 != 1) return false;
    }
    
    return true;
}
//香港身份ID验证
function check_hkid($id)
{
    if (!preg_match("/^[a-zA-Z][0-9]{6}[0-9aA]$/", $id)) {
        return false;
    }
    $mul = 8;
    $sum = (ord(strtoupper($id))-64) * $mul;
    while($mul>1) {
        $sum += intval(substr($id, 8 - $mul, 1)) * $mul;
        $mul --;
    }
    $chksum = dechex(strval(11-($sum % 11)));//dec to hex
    if ($chksum == 'b') {
        $chksum = 0;
    }
    return $chksum == strtolower(substr($id, 7, 1));
}

/**
 * 数据基础验证，判断日期是否是Y-m-d格式
 * @param unknown_type $value
 * @return boolean
 */
function is_date($value)
{
    $arr=explode('-',$value);
    if(count($arr) < 3)
    {
        return false;
    }
    return checkdate($arr[1],$arr[2],$arr[0])?true:false;
}
/**
 * 多维数组排序
 * @param array $arrays 需要排序的数组
 * @param string $sort_key 需要排序的key
 * @param string $sort_order 排序的顺序
 * @param string $sort_type 排序类型
 * @author hanliqiang
 * @date 2016年3月17日
 */
function my_array_multisort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){
    if(is_array($arrays)){
        foreach ($arrays as $array){
            if(is_array($array)){
                $key_arrays[] = $array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
    return $arrays;
}
/**
 *	数据基础验证-是否是移动电话 验证：1385810XXXX
 *  Controller中使用方法：$this->controller->is_mobile($value)
 * 	@param  string $value 需要验证的值
 *  @return bool
 */
function is_mobile($value) {
    return preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?(10|11|13|14|15|17|18)\d{9}$/', trim($value));
}
/**
 * 时间的人性化描述
 * @param int $timestamp
 * @param int $nowTime
 * @version update 2015.5.28 lxm 增加$nowTime参数
 */
function timeDescription($timestamp, $nowTime = 0)
{
    if(empty($timestamp))
    {
        return '';
    }
    !empty($nowTime) or $nowTime = time();
    
    $dur = $nowTime - $timestamp;
    if($dur < 0){
        return '';
    }
    else if($dur < 60)
    {
        return $dur.'秒';
    }
    else if($dur < 3600)
    {
        $temp = floor($dur/60);
        return $temp."分钟";
    }
    elseif($dur < 86400)
    {
        $temp = floor($dur/3600);
        return $temp.'小时';
    }
    else{
        $temp = floor($dur/86400);
        return $temp.'天';
    }
}
/**
 * 生成机器id
 * @return array
 * @author zhaoce
 */
function readMachineId(): array {
    $hostname = $_SERVER['SERVER_NAME'];
    return getBinaryBytes(md5($hostname));
}

/**
 * 16进制-》10进制数组
 * @param $string
 * @return array
 * @author zhaoce
 */
function getBinaryBytes($string): array {
    $str = [];
    for($i = 0; $i < 16; $i++) {
        $str[] = hexdec(substr($string, $i*2, 2));
    }
    return $str;
}

/**
 * 10进制数组转字符串
 * @param $bytes
 * @return string
 * @author zhaoce
 */
function getBytesToString($bytes): string {
    $str = '';
    foreach($bytes as $b){
        $str .= chr($b);
    }
    return $str;
}

/**
 * 获取一个4字节随机数
 * @return int
 * @author zhaoce
 */
function readRandomUint32() {
    $b = [];
    for($i = 0; $i < 4; $i++){
        $b[] = rand(0, 255);
    }
    return $b[0] << 0 | $b[1] << 8 | $b[2] << 16 | $b[3] << 24;
}

/**
 * 获取MsgID
 * @return string
 * @author zhaoce
 */
function genMsgID(): string {
    
    $b = [];
    // Timestamp, 4 bytes, big endian
    $unixTime =  time();
    $b[0] =$unixTime  >> 24 & 0xff;
    $b[1] = $unixTime >> 16 & 0xff;
    $b[2] = $unixTime >> 8 & 0xff;
    $b[3] = $unixTime & 0xff;
    // Machine, first 3 bytes of md5(hostname)
    $machineId = readMachineId();
    $b[4] = $machineId[0];
    $b[5] = $machineId[1];
    $b[6] = $machineId[2];
    // Pid, 2 bytes, specs don't specify endianness, but we use big endian.
    $b[7] = getmygid()>> 8;
    $b[8] = getmygid();
    // Increment, 3 bytes, big endian
    $i = readRandomUint32();
    $b[9] = $i >> 16;
    $b[10] = $i >> 8;
    $b[11] = $i;
    return mb_convert_encoding(getBytesToString($b), 'utf-8', 'ascii');
}