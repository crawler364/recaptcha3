<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$APPLICATION->AddHeadScript($arResult['URL']);
?>
<input id="<?= $arResult['CAPTCHA_SID_ID'] ?>" class="wc-captcha-sid" type="text" name="captcha_sid"
       value="<?= htmlspecialcharsbx($arResult['CAPTCHA_SID']); ?>"/>
<input id="<?= $arResult['CAPTCHA_WORD_ID'] ?>" class="wc-captcha-word" type="text" name="captcha_word" value=""/>
<div id="<?= $arResult['BADGE_ID'] ?>" class="wc-badge"></div>
<script type="text/javascript">
    recaptcha3 = new ReCaptcha3();
    recaptcha3.init(<?=Bitrix\Main\Web\Json::encode([
        'signedParameters' => $this->getComponent()->getSignedParameters(),
        'badgeId' => $arResult['BADGE_ID'],
        'captchaSidId' => $arResult['CAPTCHA_SID_ID'],
        'captchaWordId' => $arResult['CAPTCHA_WORD_ID'],
    ])?>);
</script>