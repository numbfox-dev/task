<?
$pre_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
include_once($_SERVER['DOCUMENT_ROOT'] . $pre_path . '/loader.php');

router()->run();