<?
class action_new {
	
	public function new_task() {
		
		if (!empty($_POST['username']) and !empty($_POST['email'] and !empty($_POST['text']))) {
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$result = 'Введите корректный e-mail';
			} else {
				db()->insert('tasks', ['username' => $_POST['username'], 'email' => $_POST['email'], 'text' => $_POST['text']])->apply();
				$result = 'Задача успешно добавлена';
			}
		} else {
			$result = 'Заполните все поля';
		}
		
		echo $result;
	}
	
}