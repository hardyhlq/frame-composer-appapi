<?php
namespace ChelerApi\runtime;

use ChelerApi\ChelerApi;
use ChelerApi\dao\nosql\CNosqlInit;

/**
 * 核心类
 *
 * 保存单例加载的实例
 *
 * @author lonphy(dev@lonphy.com)
 * @version 1.0
 */
class CCore
{

    public static $instance = [];
    // 单例容器
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $this->run_register_global(); // 注册全局变量
    }

    /**
     * 框架核心加载-框架的所有类都需要通过该函数出去
     * 1.
     * 单例模式
     * 2. 可以加载-Controller，Service，View，Dao，Util，Library中的类文件
     * 3. 框架加载核心函数
     * 使用方法：$this->load($class_name, $type)
     *
     * @param string $class_name
     *            类名称
     * @param string $type
     *            类别
     */
    protected static function load($classname)
    {
        if (! isset(self::$instance['loadclass'][$classname])) {
            if (! class_exists($classname)) {
                ChelerApi::throwError($classname . ' is not exist!');
            }
            
            $obj = new $classname();
            self::$instance['loadclass'][$classname] = $obj;
        }
        return self::$instance['loadclass'][$classname];
    }

    /**
     * 系统获取library下面的类
     * 1.
     * 通过$this->getLibrary($class) 就可以加载Library下面的类
     * 2. 单例模式-通过load核心函数加载
     * 全局使用方法：$this->getLibrary($class)
     *
     * @param string $class_name
     *            类名称
     * @return object
     */
    public function getLibrary($class)
    {
        $fullClassName = '\ChelerApi\library\\L' . $class;
        return $this->load($fullClassName);
    }

    /**
     * 系统获取Util类函数
     * 1.
     * 通过$this->getUtil($class) 就可以加载Util下面的类
     * 2. 单例模式-通过load核心函数加载
     * 全局使用方法：$this->getUtil($class)
     *
     * @param string $class_name
     *            类名称
     * @return object
     */
    public function getUtil($class)
    {
        $fullClassName = '\ChelerApi\util\\U' . $class;
        return $this->load($fullClassName);
    }

    /**
     * 获取缓存对象
     * 全局使用方法：$this->getCache()
     *
     * @return \ChelerApi\cache\CMemcached
     */
    public function getCache()
    {
        if (! isset(self::$instance['_cache_'])) {
            $cache = $this->load('\ChelerApi\cache\CMemcached');
            $cache->add_server(ChelerApi::getConfig('memcache'));
            self::$instance['_cache_'] = $cache;
        }
        return self::$instance['_cache_'];
    }

    /**
     * 获取m
     * 全局使用方法：$this->getM()
     *
     * @return
     *
     */
    public static function getM()
    {
        $conf = ChelerApi::getConfig();
        if ($conf['ismodule'] === false)
            return '';
        if (! isset($_GET['m']) || empty($_GET['m'])) {
            return $conf['controller']['default_module'];
        }
        return $_GET['m'];
    }

    /**
     * 获取c
     * 全局使用方法：$this->getC()
     *
     * @return
     *
     */
    public static function getC()
    {
        $conf = ChelerApi::getConfig();
        if (! isset($_GET['c']) || empty($_GET['c'])) {
            return $conf['controller']['default_controller'];
        }
        return $_GET['c'];
    }

    /**
     * 获取a
     * 全局使用方法：$this->getA()
     *
     * @return
     *
     */
    public static function getA()
    {
        $conf = ChelerApi::getConfig();
        if (! isset($_GET['a']) || empty($_GET['a'])) {
            return $conf['controller']['default_action'];
        }
        return $_GET['a'];
    }

    /**
     * 获取缓存对象
     * 全局使用方法：$this->getMemcache()
     *
     * @param  string $serverName
     * @return mixed memcache对象
     * @author lixin
     */
    public function getMemcache(string $serverName)
    {
        if (!isset(self::$instance['_cache_'][$serverName])) {
            $cache = $this->load('\ChelerApi\cache\CMemcached');
            $config = ChelerApi::getConfig('memcache');
            $cache->add_server($config[$serverName]);
            self::$instance['_cache_'][$serverName] = $cache;
        }
        return self::$instance['_cache_'][$serverName];
    }
    
    /**
     * 获取缓存对象
     * 全局使用方法：$this->getRedis()
     *
     * @param  string $serverName
     * @return mixed redis对象
     * @author lixin
     */
    public function getRedis(string $serverName)
    {
        if (!isset(self::$instance['_redis_'][$serverName])) {
            $redis = $this->load('\ChelerApi\cache\CRedis');
            $config = ChelerApi::getConfig('redis');
            $redis->add_server($config[$serverName]);
            self::$instance['redis'][$serverName] = $redis;
        }
        return self::$instance['redis'][$serverName];
    }
    
    /**
     * 获取CNosqlInit对象
     * @param string $type redis|mongo
     * @param array $server 配置
     * @return CNosqlInit
     * @author lixin
     */
    public function getNosql($type, $server)
    {
        if (isset(self::$instance['_nosql_']) && self::$instance['_nosql_'] != NULL) {
            return self::$instance['_nosql_'];
        } else {
            $dao = $this->load('\ChelerApi\dao\CDao'); //导入Dao
            self::$instance['_nosql_'] = $dao->run_nosql($type, $server); //初始化nosql
            return self::$instance['_nosql_'];
        }
    }
    
    /**
     * 获取NOSQL对象中的Mongo
     * 全局使用方法：$this->getMongo()->
     * 使用Mongo，你的服务器端需要安装Mongo
     * 需要在配置文件中配置$InitPHP_conf['mongo'][服务器server]
     * 如果多个mongo分布，则直接可以改变$server就可以切换
     * @param string $server 配置
     * @return CMongoInit
     * @author lixin
     */
    public function getMongo($server = 'default') {
        $instance_name = 'mongo_' . $server;
        
        if (isset(CNosqlInit::$instance[$instance_name]) && CNosqlInit::$instance[$instance_name] != NULL) {
            return CNosqlInit::$instance[$instance_name];
        } else {
            return $this->getNosql('MONGO',$server)->init('MONGO', $server);
        }
    }
    
    /**
     * 注册到框架全局可用变量
     *
     * @param string $name
     *            变量名称
     * @param val $value
     *            变量值
     */
    public function register_global($name, $value)
    {
        self::$instance['global'][$name] = $value;
        $this->$name = $value;
    }

    /**
     * 运行全局变量
     */
    private function run_register_global()
    {
        if (isset(self::$instance['global']) && ! empty(self::$instance['global'])) {
            foreach (self::$instance['global'] as $key => $value) {
                $this->$key = $value;
            }
        }
    }
}