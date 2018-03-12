<?php
namespace app\dao\mongodb;

use frame\runtime\MongoDao;

class MongoLog extends MongoDao {
    protected $col = "login_log";
    protected $mongoDb = "carlt_log";
    protected $serverName = "log";//$_CONFIG_['mongo']['log']['server']     = '127.0.0.1';配置中的log

    public function insert($data) {
        return $this->init_mongo($this->mongoDb, $this->col)->bulkWriteInster($data);
    }
}