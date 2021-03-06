<?php
/**
 *
 * 订阅redis key过期事件worker
 * Created by PhpStorm.
 * User: marin
 * Date: 2017/12/18
 * Time: 16:49
 */

namespace App\worker;
use App\subscribleMaster;
use App\lib\Config;
use App\worker\job\ClearCache;

class CacheClearWorker
{
    protected $_worker = null;
    public $_clearCacheSection = null;

    public function __construct(\swoole_process $worker)
    {
        $this->_worker = $worker;
        $this->_clearCacheSection = Config::getConfig('clearCache_section');
        swoole_set_process_name(sprintf($this->getWorkerProcessName().':%s','worker'));
        error_log(date('Y-m-d H:i:s')."\t: The Worker Process Worker Start!".PHP_EOL,3,LOG_PATH.'ClearCacheWork.log');
        $this->workerStart();
    }

    /**
     * 开始工作
     */
    public function workerStart()
    {
        try {

            ClearCache::run();
            swoole_timer_tick(10000,[$this,'checkMainProcessIFexists']);
           }catch (\Exception $exception){
            error_log(date('Y-m-d H:i:s')."\t"."Message:{$exception->getMessage()}, 
              ClearCacheWork Quit!,ErrorCode:{$exception->getCode()}.\n",3,LOG_PATH.'ClearCacheWork.log');
            $this->_worker->exit(0);
        }
    }

    public static  function Start(\swoole_process $worker)
    {
        new self($worker);
    }


    /**
     * 获取子进程 ,eq (clear_master:redis_cache_clear)
     * @return string
     */
    public function getWorkerProcessName()
    {

        return sprintf($this->_clearCacheSection->panda_process.':%s',$this->_clearCacheSection->children->redis_cache_clear);
    }
    /**
     * 获取主进程
     */
    public function getMpProcessName()
    {
        $prefix = $this->_clearCacheSection->panda_process .':%s';
        return sprintf($prefix,$this->_clearCacheSection->master->clear_master_name);
    }
    /**
     * 检查主进程是否存在
     * @param $timerId
     * @param \swoole_process $worker
     */
    public function checkMainProcessIFexists()
    {
        $mpId = subscribleMaster::getMpId();
        error_log('time:'.time().PHP_EOL,3,LOG_PATH.'CacheClearWorkerCheck.log');
        if(!\swoole_process::kill($mpId,0)){//父进程已经不存在,退出当前worker,回收进程资源
            error_log(date('Y-m-d H:i:s')."\t"."Message:  check ClearCacheWork Quit!",3,LOG_PATH.'ClearCacheWork.log');
            $this->_worker->_exit();
        }
    }
}