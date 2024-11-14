<?php
/**
 * Time: 2024/11/14
 * Describe: use Aliyun SMS API
 * Auther: WangMaixin
 */
namespace Boot\Controller;

use Boot\Controller\Controller;


use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;

class SmsController extends Controller {
    public function send() {
        var_dump(self::main());
    }

    private static function createClient(){
        // 工程代码泄露可能会导致 AccessKey 泄露，并威胁账号下所有资源的安全性。以下代码示例仅供参考。
        // 建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/311677.html。
        $config = new Config([
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_ID。
            "accessKeyId" => Controller::getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"),
            // 必填，请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_SECRET。
            "accessKeySecret" => Controller::getenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET")
        ]);
        // Endpoint 请参考 https://api.aliyun.com/product/Dysmsapi
        $config->endpoint = "dysmsapi.aliyuncs.com";
        $config->protocol = "HTTP";
        return new Dysmsapi($config);
    }

    private static function main(){
        $client = self::createClient();
        $sendSmsRequest = new SendSmsRequest([
            "signName" => "新乡市迷小网络科技",
            "templateCode" => "SMS_475210286",
            "phoneNumbers" => "13043735391",
            // 变量再此修改
            "templateParam" => "{
                \"name\":\"王灿锦\",
                \"jobid\":\"A001\",
                \"businunit\":\"董事会\",
                \"department\":\"董事会\",
                \"jobname\":\"王灿锦\",
                \"time\":\"2024-11-14\",
                \"address\":\"新乡总公司\"
            }"
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $result = json_encode($client->sendSmsWithOptions($sendSmsRequest, $runtime));
            $json_result = json_decode($result, true);
            
            return $json_result['body']['code'];
        }
        catch (Exception $error) {
            echo json_encode($error);
        }
    }
}
?>