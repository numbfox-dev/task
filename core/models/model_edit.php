<?

class model_edit {

    public function get_data($action) {
		
		$task = db()->select('tasks')->where('id', $action)->first();
		
		$data = [
			'title' => 'Редактировать задачу',
			'task' => $task,
		];

        return $data;
    }

}
