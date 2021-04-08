<?php

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\AjaxJson;

class WCReCaptcha3AjaxController extends Controller
{
    public function configureActions(): array
    {
        return [
            'getParams' => [
                'prefilters' => [], 'postfilters' => [],
            ],
            'siteVerify' => [
                'prefilters' => [], 'postfilters' => [],
            ],
            'getCaptchaWord' => [
                'prefilters' => [], 'postfilters' => [],
            ],
        ];
    }

    public function siteVerifyAction($token)
    {
        $result = new \Bitrix\Main\Result();
        $httpClient = new \Bitrix\Main\Web\HttpClient();
        $unsignedParameters = $this->getUnsignedParameters();
        $ip = \Bitrix\Main\Context::getCurrent()->getServer()->get('REMOTE_ADDR');
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $url = "$url?secret={$unsignedParameters['SECRET_KEY']}&response=$token&remoteip=$ip";

        if ($get = $httpClient->get($url)) {
            $result->setData(\Bitrix\Main\Web\Json::decode($get));
        } else {
            $result->addError();
        }

        return new AjaxJson($result->getData(), 'success', $result->getErrorCollection());
    }

    public function getCaptchaWordAction($captchaSid): array
    {
        global $DB;
        $results = $DB->Query("SELECT distinct `CODE` FROM `b_captcha` WHERE `ID`='$captchaSid'");
        if ($captchaWord = $results->Fetch()['CODE']) {
            return ['captchaWord' => $captchaWord];
        }
    }
}
