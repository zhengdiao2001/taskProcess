<?php
/**
 * Created by PhpStorm.
 * User: marin
 * Date: 2017/12/16
 * Time: 10:23
 */
namespace App\config;
class AppConf{
    /**
     * 需要处理的缓存key
     */
    const EXPIRE_KEY=[
        'users.id',//网吧账号
        'active_config.netbar_id',//网吧活动配置
        'users_netbar.user_id',//网吧账号详情记录
        'users_netbar_person.user_id',//网吧员工详情记录
        'overwatch_activity_config.netbar_id',//OW网吧活动配置表
        'netbar_notice.netbar_id',//网吧公告配置
        'base_config.netbar_id',//基础配置
        'voice_config.netbar_id',//语言配置
        'client_config.netbar_id',//客户端配置
        'startup_info.netbar_id',//开机启动配置
        'integral_config.netbar_id',//积分配置
        'lucky_draw_config.netbar_id',//在线抽奖配置
        'online_vod.netbar_id',//歌曲点播配置
        'second_kill_config.netbar_id',//秒杀活动配置
        'alipay_netbar.netbar_id',//支付宝签约配置
        'xm_activity_config.netbar_id',//官方活动配置
        'recharge_config.netbar_id'//我也不知道的啥鸡巴配置
    ];

    /**
     * kafka应用配置(consumer)
     * @var $kafkaConsumerAppConfig array
     */
    static $kafkaConsumerAppConfig =[
        'RefreshIntervalMs'=>300000,//默认5分钟刷新一次
        'GroupId'=>'test',//Client group id string. All clients sharing the same group.id belong to the same group.
        'BrokerVersion'=>'1.0.0',//User supplied broker version
        'Topics'=>['test'],//topic name group
        'OffsetReset'=>'earliest'//Action to take when there is no initial offset in offset store or the desired offset is out of range
    ];

    /**
     * kafka应用配置(producer)
     * @var $kafkaProducerAppConfig array
     */
    static $kafkaProducerAppConfig =[
        //todo 待完善
    ];
}