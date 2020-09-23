<?

function home($postfix = '') {
	$pre_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
	return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $pre_path . $postfix;
}

function redirect($address, $time = 0): void {
	echo '<meta http-equiv="refresh" content="' . $time . '; URL=' . $address . '">';
}

//Добавляет к файлу его время изменения в виде get-запроса
function dynamic_file_name($file_path) {
	$pre_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
	return home($file_path . '?' . filemtime($_SERVER['DOCUMENT_ROOT'] . $pre_path . $file_path));
}

function login_admin() {
	if (isset($_SESSION['id']) and $_SESSION['access'] == 1) {
		return true;
	} else {
		return false;
	}
}