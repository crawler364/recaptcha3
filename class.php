<?

class WCReCaptcha3 extends CBitrixComponent
{
    public function executeComponent()
    {
        global $APPLICATION;
        $uniqid = uniqid();
        $this->arResult['CAPTCHA_SID_ID'] = 'jsWcCaptchaSid' . $uniqid;
        $this->arResult['CAPTCHA_WORD_ID'] = 'jsWcCaptchaWord' . $uniqid;
        $this->arResult['BADGE_ID'] = "jsWcReCaptchaBadge" . $uniqid;
        $this->arResult['URL'] = 'https://www.google.com/recaptcha/api.js?render=explicit';
        $this->arResult['CAPTCHA_SID'] = $APPLICATION->CaptchaGetCode();

        $this->includeComponentTemplate();
    }

    protected function listKeysSignedParameters(): array
    {
        return ['SITE_KEY', 'SECRET_KEY', 'ACTION', 'SCORE', 'POSITION'];
    }
}
