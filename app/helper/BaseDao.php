<?php 
namespace app\helper;
use frame\runtime\Dao;

class  BaseDao extends Dao
{
    protected $table_name;
    protected $db;

    /**
     * 缓存KEY
     * @param string $key
     */
    public function cacheKey(string $key): string {
        return $this->table_name . '_' . $key;
    }

    /**
     * getOneByField
     * @param array $field
     * @return array
     */
    public function getOneByField( array $field )
    {
        return $this->init_db( $this->db )->get_one_by_field( $field, $this->table_name );
    }
    
    /**
     * getAllByField
     * @param array $field
     * @return array
     */
    public function getAllByField( array $field )
    {
        return $this->init_db( $this->db )->get_all_by_field( $field, $this->table_name );
    }
    
    /**
     * insert
     * @param array $data
     * @return int insert_key
     */
    public function insert( array $data )
    {
        return $this->init_db( $this->db )->insert( $data, $this->table_name );
    }
    
    /**
     * insertMore
     * @param array $field
     * @param array $data
     * @return int 0:fail 1:success
     */
    public function insertMore( array $field, array $data )
    {
        return $this->init_db( $this->db )->insert_more( $field, $data, $this->table_name );
    }
    
    /**
     * updateByField
     * @param array $data
     * @param array $field
     * @return int 0:fail n:success number
     */
    public function updateByField( array $data, array $field )
    {
        return $this->init_db( $this->db )->update_by_field( $data, $field, $this->table_name );
    }
    
    /**
     * deleteByField
     * @param array $field
     * @return int false:fail true:success
     */
    public function deleteByField( array $field )
    {
        return $this->init_db( $this->db )->delete_by_field( $field, $this->table_name );
    }
    
    /**
     * query
     * @param string $sql
     * @param bool $isSetDefault | true使用默认数据库，false使用所选数据库
     * @return mix
     */
    public function query( $sql, bool $isSetDefault = true )
    {
        return $this->init_db( $this->db )->query( $sql, $isSetDefault );
    }
    
    /**
     * getOneSql
     * @param string $sql
     * @return array
     */
    public function getOneSql( $sql )
    {
        return $this->init_db( $this->db )->get_one_sql( $sql );
    }
    
    /**
     * getAllSql
     * @param string $sql
     * @return array
     */
    public function getAllSql( $sql )
    {
        return $this->init_db( $this->db )->get_all_sql( $sql );
    }
}
?>