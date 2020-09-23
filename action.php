<?
$pre_path = str_replace('/action.php', '', $_SERVER['SCRIPT_NAME']);
include_once($_SERVER['DOCUMENT_ROOT'] . $pre_path . '/loader.php');

if (isset($_POST)) {
	$key = key($_POST);
	$value = $_POST[$key];
	$key = 'action_' . $key;

	include_once(DOCUMENT_ROOT . '/core/actions/' . $key . '.php');
	$action = new $key();
	$action->$value();
}