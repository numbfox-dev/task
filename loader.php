<?
$pre_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
$pre_path = str_replace('/action.php', '', $pre_path);
define('DOCUMENT_ROOT', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . $pre_path);

function include_classes(): void {
    $folder = scandir(DOCUMENT_ROOT . '/classes');

    for ($i = 2, $max = sizeof($folder); $i < $max; $i++) {
        if (!is_dir(DOCUMENT_ROOT . '/classes/' . $folder[$i])) {
            include_once(DOCUMENT_ROOT . '/classes/' . $folder[$i]);
        }
    }
}

include_classes();
session_start();