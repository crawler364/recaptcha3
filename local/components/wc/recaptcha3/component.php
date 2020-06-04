<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$uniqid = uniqid('', false);
$arResult['CAPTCHA_SID_ID'] = 'jsWcCaptchaSid' . $uniqid;
$arResult['CAPTCHA_WORD_ID'] = 'jsWcCaptchaWord' . $uniqid;
$arResult['BADGE_ID'] = "jsWcReCaptchaBadge" . $uniqid;
$arResult['URL'] = 'https://www.google.com/recaptcha/api.js?render=explicit';
$arResult['CAPTCHA_SID'] = $APPLICATION->CaptchaGetCode();

$this->IncludeComponentTemplate();