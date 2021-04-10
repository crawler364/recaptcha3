<?

class WCReCaptcha3 extends CBitrixComponent
{
    protected function listKeysSignedParameters(): array
    {
        return ['SECRET_KEY', 'SCORE'];
    }

    public function executeComponent()
    {
        global $APPLICATION;

        $this->arResult['CAPTCHA_SID'] = $APPLICATION->CaptchaGetCode();

        $this->includeComponentTemplate();
    }
}
