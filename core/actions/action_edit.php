<?
class action_edit {
	
	public function edit_task() {
		
		if (login_admin()) {
			if (!empty($_POST['username']) and !empty($_POST['email'] and !empty($_POST['text']))) {
				if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
					$result = 'Введите корректный e-mail';
				} else {
					
					$current = db()->select('tasks')->where('id', $_POST['id'])->first();
					
					if ($current->text == $_POST['text'] and $current->edited == 0) {
						$edited = 0;
					} else {
						$edited = 1;
					}
					
					db()->update('tasks', ['username' => $_POST['username'], 'email' => $_POST['email'], 'text' => $_POST['text'], 'edited' => $edited])->where('id', $_POST['id'])->apply();
					$result = 'Задача успешно изменена';
				}
			} else {
				$result = 'Заполните все поля';
			}
		} else {
			$result = 'Ошибка авторизации';
		}
		
		echo $result;
	}
	
}