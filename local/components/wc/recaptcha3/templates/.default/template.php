<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Web\Json;

$APPLICATION->AddHeadScript('https://www.google.com/recaptcha/api.js?render=' . $arParams['SITE_KEY']);
?>
<input id="wcCaptchaSid" type="text" name="captcha_sid" value="<?= htmlspecialcharsbx($arResult['CAPTCHA_SID']); ?>"/>
<input id="wcCaptchaWord" type="text" name="captcha_word" value=""/>
<script type="text/javascript">
    const recaptcha3 = new ReCaptcha3(<?=Json::encode(['signedParameters' => $this->getComponent()->getSignedParameters()])?>);
    recaptcha3.handler();
</script>