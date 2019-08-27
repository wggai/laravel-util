<?php
/**
 * Created by PhpStorm.
 * User: linzhencan
 * Date: 2019/7/24
 * Time: 18:49
 */

namespace Wggai\LaravelUtil\Aliyun\Sms;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

use Wggai\LaravelUtil\Exception\ApiException;

class SendSms
{

    // Download：https://github.com/aliyun/openapi-sdk-php
    // Usage：https://github.com/aliyun/openapi-sdk-php/blob/master/README.md

    private $driver;
    private $access_key_id;
    private $access_key_secret;
    private $sign_name;

    public function __construct()
    {
        $this->driver = config("sms.driver");
        $this->access_key_id = config("sms.{$this->driver}.access_id");
        $this->access_key_secret = config("sms.{$this->driver}.access_secret");
        $this->sign_name = config("sms.{$this->driver}.sign_name");
    }

    private function result_format ($res)
    {
        return $res;
    }

    public function verificationCode ($phone, $code, &$log_sms = [])
    {
        // 使用sms配置文件指定模板
        $TEMPLET = "1";

        $region_id = "cn-hangzhou";
        $phone_numbers = $phone;
        $sign_name = $this->sign_name;
        $template_code = config("sms.templet.{$TEMPLET}.template_code");
        $template_param = json_encode(['code'=>"{$code}"]);

        $sms_type = config("sms.templet.{$TEMPLET}.sms_type");
        $template = config("sms.templet.{$TEMPLET}.content");


        try {

            AlibabaCloud::accessKeyClient($this->access_key_id, $this->access_key_secret)
                ->regionId($region_id)
                ->asDefaultClient();

            $query = [
                'RegionId' => $region_id,
                'PhoneNumbers' => $phone_numbers,
                'SignName' => $sign_name,
                'TemplateCode' => $template_code,
                'TemplateParam' => $template_param,
            ];
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options(['query' => $query])
                ->request();
            $result_data = $result->toArray();

            $log_sms = [
                'phone' => $phone_numbers,
                'content_json' => $template_param,
                'driver' => $this->driver,
                'type' => $sms_type,
                'template_code' => $template_code,
                'template' => $template,
                'sign_name' => $this->sign_name,
                'result_json' => json_encode($result_data),
                'code' => $code,
            ];

            return $this->result_format($result_data);

        } catch (ClientException $e) {
            throw new ApiException($e->getErrorMessage());
        } catch (ServerException $e) {
            throw new ApiException($e->getErrorMessage());
        }

        throw new ApiException("发送短信失败！");
    }


}