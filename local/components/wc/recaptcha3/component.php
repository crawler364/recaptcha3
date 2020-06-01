<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arResult['CAPTCHA_SID'] = $APPLICATION->CaptchaGetCode();

$this->IncludeComponentTemplate();