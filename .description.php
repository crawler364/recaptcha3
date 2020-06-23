<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    'NAME' => GetMessage('RECAPTCHA_COMPONENT_NAME'),
    'DESCRIPTION' => GetMessage('RECAPTCHA_COMPONENT_DESCRIPTION'),
    'CACHE_PATH' => 'N',
    'PATH' => [
        'ID' => GetMessage('RECAPTCHA_COMPONENT_DEV_NAME'),
        'NAME' => GetMessage('RECAPTCHA_COMPONENT_DEV_NAME'),
        'CHILD' => [
            'ID' => GetMessage('RECAPTCHA_COMPONENT_NAME'),
            'NAME' => GetMessage('RECAPTCHA_COMPONENT_NAME'),
        ],
    ],
];
?>