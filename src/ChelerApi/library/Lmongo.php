<?php
namespace ChelerApi\library;

use ChelerApi\ChelerApi;

/**
 * *******************************************************************************
 * InitPHP 3.3 国产PHP开发框架 扩展类库-消息服务器下发
 * -------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 * -------------------------------------------------------------------------------
 *
 * @author :hanliqiang
 *         @date:2015-12-16
 *         *********************************************************************************
 */
class Lmongo
{

    public $connection;

    /**
     * 实例化mongo
     */
    public function __construct()
    {
        if (! $this->connection) {
            try {
                $config = ChelerApi::getConfig();
                $mongoConfig = $config['mongo']['log'];
                $this->connection = new \MongoDB\Driver\Manager("mongodb://" . $mongoConfig['server'] . ":" . $mongoConfig['port']);
            } catch (\Exception $e) {
                $this->connection = null;
            }
        }
    }

    /**
     * executeBulkWrite
     *
     * @author lxm
     *         @verion 2.0
     */
    private function _executeBulkWrite($bulk, $mongoDB, $collection)
    {
        if ($manager = $this->connection) {
            $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
            $db = $mongoDB . '.' . $collection;
            
            try {
                $result = $manager->executeBulkWrite($db, $bulk, $writeConcern);
                // TEST Query
                return $result;
            } catch (\MongoDB\Driver\Exception\BulkWriteException $e) {
                return;
            } catch (\MongoDB\Driver\Exception\Exception $e) {
                return;
            }
        }
    }

    /**
     * mongod inster
     *
     * @param object|array $document            
     * @param string $mongoDB            
     * @param string $collection            
     * @uses $db = $mongoDB . '.' . $collection
     *       $db = 'db.collection'
     * @author lxm
     * @version 2.0
     */
    public function bulkWriteInster($document, $mongoDB, $collection)
    {
        if (empty($document) || empty($mongoDB) || empty($collection))
            return [];
        $bulk = new \MongoDB\Driver\BulkWrite();
        $document_id = $bulk->insert($document);
        $result = $this->_executeBulkWrite($bulk, $mongoDB, $collection);
        return (string) $document_id;
    }

    /**
     * mongod update
     *
     * @param array $set            
     * @param string $document_id            
     * @param string $mongoDB            
     * @param string $collection            
     * @uses $db = $mongoDB . '.' . $collection
     *       $db = 'db.collection'
     * @author lxm
     * @version 2.0
     */
    public function bulkWriteUpdate(array $set, $document_id, $mongoDB, $collection)
    {
        if (empty($document_id) || empty($mongoDB) || empty($collection))
            return [];
        $bulk = new \MongoDB\Driver\BulkWrite();
        $document_id = $bulk->update([
            '_id' => new \MongoDB\BSON\ObjectId($document_id)
        ], [
            '$set' => $set
        ]);
        $result = $this->_executeBulkWrite($bulk, $mongoDB, $collection);
        return (string) $document_id;
    }

    /**
     * mongod query
     *
     * @param array|object $filter            
     * @param array $options            
     * @link http://php.net/manual/zh/mongodb-driver-query.construct.php
     * @author lxm
     *         @verion 2.0
     */
    public function query($db, array $filter, array $options)
    {
        if ($manager = $this->connection) {
            $readPreference = new \MongoDB\Driver\ReadPreference(\MongoDB\Driver\ReadPreference::RP_PRIMARY);
            $query = new \MongoDB\Driver\Query($filter, $options);
            $cursor = $manager->executeQuery($db, $query, $readPreference);
        }
        
        return $cursor->toArray();
    }
}