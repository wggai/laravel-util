<?php
/**
 * Created by PhpStorm.
 * User: linzhencan
 * Date: 2019/7/24
 * Time: 18:49
 */

return [

    'driver' => 'aliyun',  // 选择使用的运营商  alidayu,aliyun,tencent

    'create_log' => true,   // 是否生成日志
    'log_save' => 'mysql',   // 保存类型：mysql、file(未实现)

    // 阿里大于
    'alidayu' => [
        'access_id' => env('SMS_ACCESS_ID', null),
        'access_secret' => env('SMS_ACCESS_SECRET', null),
        'sign_name' => env('SMS_SIGN_NAME', null)
    ],

    // 阿里云
    'aliyun' => [
        'access_id' => env('SMS_ACCESS_ID', null),
        'access_secret' => env('SMS_ACCESS_SECRET', null),
        'sign_name' => env('SMS_SIGN_NAME', null)
    ],

    // 模板内容
    'templet' => [
        1 => [
            'template_code' => 'SMS_171192019',                                          // 模板代码
            'content' => '您的验证码：${code}，您正进行身份验证，打死不告诉别人！',        // 消息模板
            'type' => 'verification',                                                   // verification:验证码;notification:通知短信
            'sms_type' => 1                                                             // 1=verification:验证码;2=notification:通知短信
        ]
    ],

    // 错误码
    'error_msg' => [
        'aliyun' => [
            'isv' => [
                'MOBILE_NUMBER_ILLEGAL' => '非法手机号！',
            ],
        ],
    ],

    // verification:验证码 有效时间 秒
    'valid_time' => 120,

    // 发送频率限制
    // 阿里大于和阿里云云通讯:
    // 短信验证码 ：使用同一个签名，对同一个手机号码发送短信验证码，1条/分钟，5条/小时，10条/天。一个手机号码通过阿里大于平台只能收到40条/天。
    // 短信通知： 使用同一个签名和同一个短信模板ID，对同一个手机号码发送短信通知，支持50条/日（指非自然日）。费用贵暂时不实现
    'limit' => [
        // 是否开启限制 true false
        'is_on' => true,
        'limit_per_minute' => 1,
        'limit_per_hour' => 20,
        'limit_per_day' => 40,
    ]


];