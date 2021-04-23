<?

class WCReCaptcha3 extends CBitrixComponent
{
    protected function listKeysSignedParameters(): array
    {
        return ['SECRET_KEY', 'SCORE'];
    }

    public function executeComponent()
    {
        $captcha = new CCaptcha();
        $captcha->SetCode();
        $this->arResult['CAPTCHA_SID'] = $captcha->GetSID();

        $this->includeComponentTemplate();
    }
}
