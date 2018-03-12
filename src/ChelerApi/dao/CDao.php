<?php
namespace ChelerApi\dao;

use ChelerApi\dao\db\DB;
use ChelerApi\ChelerApi;
use ChelerApi\dao\nosql\CNosqlInit;

/**
 * 数据层基类
 * @author lonphy
 */
class CDao
{
    /**
     * @var DB
     */
    public $db = NULL;

    /**
     * @var CNosqlInit
     */
    public $nosql = NULL;

    /**
     * @var CNosqlInit
     */
    public $mongoHandle = NULL;

    /**
     * 运行nosql
     */
    public function run_nosql($type, $server)
    {
        if ($this->nosql == NULL) {
            $this->nosql = ChelerApi::loadclass('ChelerApi\dao\nosql\CNosqlInit');
            $this->nosql->init($type, $server);
        }
        return $this->nosql;
    }

    /**
     * 运行nosql
     */
    public function run_mongo($type, $server)
    {
        if ($this->mongoHandle == NULL) {
            $mongoClass = ChelerApi::loadclass('ChelerApi\dao\nosql\CNosqlInit');
            $this->mongoHandle = $mongoClass->init($type, $server);
        }
        return $this->mongoHandle;
    }
}