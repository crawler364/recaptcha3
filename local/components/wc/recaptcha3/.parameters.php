<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arComponentParameters = array(
	"GROUPS" => array(
		"BASE" => array(
			"NAME" => GetMessage("COMP_FORM_GROUP_PARAMS")
		),
	),

	"PARAMETERS" => array(
		"SITE_KEY" => array(
			"NAME" => GetMessage("RECAPTCHA_SITE_KEY"),
			"TYPE" => "STRING",
			"PARENT" => "BASE",
		),
        "SECRET_KEY" => array(
            "NAME" => GetMessage("RECAPTCHA_SECRET_KEY"),
            "TYPE" => "STRING",
            "PARENT" => "BASE",
        ),

	),
);
?>