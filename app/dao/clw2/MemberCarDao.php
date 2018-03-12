<?php
namespace app\dao\clw2;

use app\helper\BaseDao;

class MemberCarDao extends BaseDao {
    protected $table_name = 'car_member_car';
    protected $db='clw2';//库名
    
    /** 
     * 根据条件查找用户信息
     * @param array $field 查询条件
     * @author hanliqiang
     * @date 2018年03月06日
     */
    public function get($field){
        if(empty($field)) return false;
        return $this->init_db($this->db)->get_one_by_field($field, $this->table_name);
    }
    /** 
     * 根据条件查找用户信息
     * @param int $uid 用户id
     * @author hanliqiang
     * @date 2018年03月06日
     */
    public function getByUid($uid){
        if($uid < 1) return false;

        $memcache = $this->getMemcache('default');
        $cache_key = $this->cacheKey($uid);

        $value = $memcache->get($cache_key);
        $value = json_decode($value, true);
        if(!$value){
            $value = $this->init_db($this->db)->get_one($uid, $this->table_name);
            $memcache->set($cache_key, json_encode($value));
        }
        return $value;
    }
}