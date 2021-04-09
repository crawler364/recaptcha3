<?php

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Error;
use Bitrix\Main\Result;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Json;

class WCReCaptcha3AjaxController extends Controller
{
    public function configureActions(): array
    {
        return [
            'siteVerify' => [
                'prefilters' => [], 'postfilters' => [],
            ],
            'processCaptcha' => [
                'prefilters' => [], 'postfilters' => [],
            ],
        ];
    }

    public function siteVerifyAction($token): AjaxJson
    {
        $result = new Result();
        $httpClient = new HttpClient();
        $unsignedParameters = $this->getUnsignedParameters();
        $ip = Context::getCurrent()->getServer()->get('REMOTE_ADDR');
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $url = "$url?secret={$unsignedParameters['SECRET_KEY']}&response=$token&remoteip=$ip";

        $get = $httpClient->get($url);
        $get = Json::decode($get);

        if ($get['success'] === true) {
            $result->setData($get);
        } else {
            foreach ($get['error-codes'] as $key => $errorCode) {
                $error = new Error($errorCode, $key);
                $result->addError($error);
            }
        }

        $isSuccess = $result->isSuccess() ? AjaxJson::STATUS_SUCCESS : AjaxJson::STATUS_ERROR;

        return new AjaxJson($result->getData(), $isSuccess, $result->getErrorCollection());
    }

    public function processCaptchaAction($captchaSid)
    {
        $result = new Result();
        global $DB;
        $results = $DB->Query("SELECT distinct `CODE` FROM `b_captcha` WHERE `ID`='$captchaSid'");
        if ($captchaWord = $results->Fetch()['CODE']) {
            return ['captchaWord' => $captchaWord];
        }
    }


}
