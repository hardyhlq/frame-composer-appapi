<?php
namespace app\service\demo;

use app\dao\clw2\Log;
use app\helper\BaseService;
use frame\ChelerApi;
use Protocol\SmsTask;

/**
 * DemoService.php
 * 描述
 * User: lixin
 * Date: 18-2-5
 */
class DemoService extends BaseService
{
    /**
     * 项目配置名
     * @var string
     */
    public $project = 'sms';

    public function getUserInfo()
    {
        return $this->_getMemberCarDao()->get(['id' => 1]);
    }

    public function protoTest(string $templateId, string $phone, string $content, int $time)
    {
        $smsTask = new SmsTask();
        $smsTask->setTime($time);
        $smsTask->setTemplateId($templateId);
        $smsTask->setPhone($phone);
        $smsTask->setContent($content);
        $str = $this->getRequestStr($smsTask);
        $client = $this->getQueue($this->_conf[$this->project]['queue']['smsTasks']);
        $client->enQueue($this->_conf[$this->project]['queue']['smsTasks']['name'], $str);
        $this->close($client->getConnectOption());
    }

    /**
     * @return Log
     */
    private function _getMemberCarDao()
    {
        return ChelerApi::getDao('clw2\MemberCar');
    }
}