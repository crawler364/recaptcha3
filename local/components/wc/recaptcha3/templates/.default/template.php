<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
$APPLICATION->AddHeadScript('https://www.google.com/recaptcha/api.js?render=' . $arParams['SITE_KEY']);
?>
<input type="text" name="captcha_sid" value="<?= htmlspecialcharsbx($arResult['CAPTCHA_SID']); ?>"/>
<input type="text" name="captcha_word" value=""/>