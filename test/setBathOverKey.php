<?php
/**
 * 批量设置过期,模拟多个key同时过期时并发情况。
 * Created by PhpStorm.
 * User: marin
 * Date: 2017/12/18
 * Time: 22:27
 */

$redis = new Redis();
$redis ->connect('192.168.1.125');
$keysOverTimeTodo = array(
    'USER_CACHE_OVERDUE:67_67',//uid_netbarId
    'USER_CACHE_OVERDUE:62_23',//uid_netbarId
    'USER_CACHE_OVERDUE:77_97',//uid_netbarId
    'USER_CACHE_OVERDUE:67_34',//uid_netbarId
    'USER_CACHE_OVERDUE:67_67',//uid_netbarId
    'USER_CACHE_OVERDUE:34_67',//uid_netbarId
    'USER_CACHE_OVERDUE:34_617',//uid_netbarId
    );
$m=0;
for ($n=0;$n<10;$n++,$m++){
    $redis ->hSet('users.id',67,time());
}

echo $m.PHP_EOL;

foreach ($keysOverTimeTodo as $item){
    $redis ->set($item,time());
    $redis ->expire($item,60);
}


//
//$now = time();
//$cache_over_time= $now+60;
//
//for ($n=0 ; $n<10000;$n++){//模拟5W并发
//    if($n==0){
//        foreach ($keysOverTimeTodo as $key=>$value)
//        {
//            $redis->set('USER_CACHE_OVERDUE:'.$value,3);
//            var_dump($redis->ExpireAt('USER_CACHE_OVERDUE:'.$value,$cache_over_time));
//        }
//    } else{
//        foreach ($keysOverTimeTodo as $key=>$value)
//        {
//            $tmpFix = strval(microtime(true).'_'.$n);
//            $redis->set('USER_CACHE_OVERDUE:'.$value.$tmpFix,3);
//            if($redis->ExpireAt('USER_CACHE_OVERDUE:'.$value.$tmpFix,$cache_over_time)==FALSE){
//                echo "Fail!".PHP_EOL;
//            };
//            usleep(100);//100毫秒
//        }
//    }
//
//}
//
//
//
//while(1) {
//    sleep(2);
//    echo "USER_CACHE_OVERDUE:674_122：" . $redis->ttl('USER_CACHE_OVERDUE:674_122') . PHP_EOL;
//    echo 'USER_CACHE_OVERDUE:66523_112222：' . $redis->ttl('USER_CACHE_OVERDUE:66523_112222') . PHP_EOL;
//    echo 'USER_CACHE_OVERDUE:674_123：' . $redis->ttl('USER_CACHE_OVERDUE:674_123') . PHP_EOL;
//    echo 'USER_CACHE_OVERDUE:67_1：' . $redis->ttl('USER_CACHE_OVERDUE:67_1') . PHP_EOL;
//    echo 'USER_CACHE_OVERDUE:67_2：' . $redis->ttl('USER_CACHE_OVERDUE:67_2') . PHP_EOL;
//    echo "===================================".PHP_EOL;
//}
