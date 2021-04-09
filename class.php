<?

class WCReCaptcha3 extends CBitrixComponent
{
    protected function listKeysSignedParameters(): array
    {
        return ['SECRET_KEY'];
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $this->arResult['CAPTCHA_ID'] = uniqid();
        $this->arResult['CAPTCHA_SID'] = $APPLICATION->CaptchaGetCode();

        $this->includeComponentTemplate();
    }
}
