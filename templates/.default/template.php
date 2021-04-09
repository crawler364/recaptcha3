<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<div id="wc-recaptcha3">
    <label>
        <input type="hidden" name="captcha_sid" data-type="captcha-sid" value="<?= $arResult['CAPTCHA_SID'] ?>"/>
    </label>
    <label>
        <input type="hidden" name="captcha_word" data-type="captcha-word" value=""/>
    </label>
    <div class="badge" data-type="badge"></div>
</div>

<script type="text/javascript">
    BX.ready(function () {
        grecaptcha.ready(function () {
            let reCaptcha3 = new ReCaptcha3(<?=Bitrix\Main\Web\Json::encode([
                'siteKey' => $arParams['SITE_KEY'],
                'position' => $arParams['POSITION'],
                'action' => $arParams['ACTION'],
                'captchaSid' => $arResult['CAPTCHA_SID'],
                'signedParameters' => $this->getComponent()->getSignedParameters(),
            ])?>);
            reCaptcha3.handler();
        })
    });
</script>
