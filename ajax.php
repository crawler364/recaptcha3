<?php

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

    public function getParamsAction(): array
    {
        $a = 123;
        /*return [
            'siteKey' => $this->arParams['SITE_KEY'],
            'secretKey' => $this->arParams['SECRET_KEY'],
            'action' => $this->arParams['ACTION'],
            'score' => $this->arParams['SCORE'],
            'position' => $this->arParams['POSITION'],
        ];*/
    }

    public function siteVerifyAction($secretKey, $token)
    {
        $server = Application::getInstance()->getContext()->getServer();
        $ip = $server->get('REMOTE_ADDR');
        $googleUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $url = "$googleUrl?secret=$secretKey&response=$token&remoteip=$ip";

        if (function_exists('curl_init')) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16');
            $curlData = curl_exec($curl);
            curl_close($curl);
        } else {
            $curlData = file_get_contents($url);
        }
        if ($curlData) {
            return Json::decode($curlData);
        }
    }

    public function getCaptchaWordAction($catpchaSid): array
    {
        global $DB;
        $results = $DB->Query("SELECT distinct `CODE` FROM `b_captcha` WHERE `ID`='$catpchaSid'");
        if ($captchaWord = $results->Fetch()['CODE']) {
            return ['captchaWord' => $captchaWord];
        }
    }
}
