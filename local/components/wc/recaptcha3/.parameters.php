<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    'GROUPS' => [
        'BASE' => [
            'NAME' => GetMessage('COMP_FORM_GROUP_PARAMS'),
        ],
    ],

    'PARAMETERS' => [
        'SITE_KEY' => [
            'NAME' => GetMessage('RECAPTCHA_SITE_KEY'),
            'TYPE' => 'STRING',
            'PARENT' => 'BASE',
        ],
        'SECRET_KEY' => [
            'NAME' => GetMessage('RECAPTCHA_SECRET_KEY'),
            'TYPE' => 'STRING',
            'PARENT' => 'BASE',
        ],
        'SCORE' => [
            'NAME' => GetMessage('RECAPTCHA_SCORE'),
            'TYPE' => 'LIST',
            'VALUES' => [
                '0.0' => '0.0',
                '0.1' => '0.1',
                '0.2' => '0.2',
                '0.3' => '0.3',
                '0.4' => '0.4',
                '0.5' => '0.5',
                '0.6' => '0.6',
                '0.7' => '0.7',
                '0.8' => '0.8',
                '0.9' => '0.9',
                '1.0' => '1.0',
            ],
            'PARENT' => 'BASE',
        ],
        'ACTION' => [
            'NAME' => GetMessage('RECAPTCHA_ACTION'),
            'TYPE' => 'LIST',
            'VALUES' => [
                'homepage' => 'homepage',
                'login' => 'login',
                'social' => 'social',
                'e-commerce' => 'e-commerce',
            ],
            'PARENT' => 'BASE',
        ],
    ],
];
?>