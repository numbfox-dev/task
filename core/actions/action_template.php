<?

class action_template {

	public function login() {
		$user = db()->select('users')->where('username', $_POST['login'])->first();	
		
		if ($user->password === md5($_POST['password'])) {
			session_start();
			$_SESSION['id'] = $user->id;		
			$_SESSION['access'] = $user->access;
		} else {
			echo 'Был введен неверный логин или пароль';
		}
	}
	
	public function logout(): void {
        session_start();
		unset($_SESSION['id']);
		unset($_SESSION['access']);
		unset($_SESSION['sort']);
		
		echo 123;
    }
	
	public function change() {
		$status = ['false' => 0, 'true' => 1];
		
		db()->update('tasks', ['status' => $status[$_POST['status']]])->where('id', $_POST['id'])->apply();
		
		if ($_POST['status'] == 'true') {
			echo 'Выполнено';
		} else {
			echo 'Не выполнено';
		}
	}
	
	public function sort_by() {
		$check = db()->manually("SHOW COLUMNS FROM `tasks` LIKE '". db()->escape($_POST['sort']) ."'")->get();
		
		if ($check[0]->Null) {
			$_SESSION['sort'] = db()->escape($_POST['sort']);
		} else {
			$_SESSION['sort'] = 'id';
		}
	}
	
}