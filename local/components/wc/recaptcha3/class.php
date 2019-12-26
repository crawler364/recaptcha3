<?

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Web\Json;

class ReCaptcha3 extends CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [];
    }

    public function getParamsAction()
    {
        return [
            'siteKey' => $this->arParams['SITE_KEY'],
            'secretKey' => $this->arParams['SECRET_KEY'],
            'action' => $this->arParams['ACTION'],
        ];
    }

    public function siteVerifyAction()
    {
        $server = Application::getInstance()->getContext()->getServer();
        $ip = $server->get('REMOTE_ADDR');
        $request = Context::getCurrent()->getRequest();
        $secretKey = $request->get('secretKey');
        $token = $request->get('token');
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
            return ['response' => Json::decode($curlData)];
        }
        return null;
    }

    public function getCaptchaWordAction()
    {
        global $DB;
        $request = Context::getCurrent()->getRequest();
        $catpchaSid = $request->get('catpchaSid');
        $results = $DB->Query("SELECT distinct `CODE` FROM `b_captcha` WHERE `ID`='$catpchaSid'");
        if ($captchaWord = $results->Fetch()['CODE']) {
            return ['captchaWord' => $captchaWord];
        }
        return null;
    }

    protected function listKeysSignedParameters()
    {
        return ['SITE_KEY', 'SECRET_KEY', 'ACTION'];
    }

}