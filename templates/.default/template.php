<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<div id="<?= $arResult['CAPTCHA_ID'] ?>" class="wc-recaptcha3">
    <label>
        <input type="text" name="CAPTCHA_SID" data-type="captcha-sid" value="<?= $arResult['CAPTCHA_SID'] ?>"/>
    </label>
    <label>
        <input type="text" name="CAPTCHA_WORD" data-type="captcha-word" value=""/>
    </label>
    <div class="badge" data-type="badge"></div>
</div>

<script type="text/javascript">
    if (!window.hasOwnProperty('ReCaptcha3')) {
        window.ReCaptcha3 = new ReCaptcha3(<?=Bitrix\Main\Web\Json::encode([
            'siteKey' => $arParams['SITE_KEY'],
            'position' => $arParams['POSITION'],
            'action' => $arParams['ACTION'],
            'signedParameters' => $this->getComponent()->getSignedParameters(),
        ])?>);
    }

    window.ReCaptcha3.init(<?=Bitrix\Main\Web\Json::encode([
        'captchaId' => $arResult['CAPTCHA_ID'],
        'captchaSid' => $arResult['CAPTCHA_SID'],
    ])?>);
</script>
