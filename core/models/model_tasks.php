<?

class model_tasks {
	
    public function get_data() {
		
		if (isset($_SESSION['sort'])) {
			$tasks = db()->select('tasks')->order([$_SESSION['sort'] => 'ASC'])->paginate(3);
		} else {
			$tasks = db()->select('tasks')->paginate(3);
		}
			
		$data = [
			'tasks' => $tasks->notes,
			'pagination' => $tasks->pages,
			'status' => ['Не выполнено', 'Выполнено'],
		];

        return $data;
    }

}