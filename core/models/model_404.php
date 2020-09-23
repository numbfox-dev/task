<?

class model_404 {

    public function get_data() {

		//Данные для главной
		$data = [
			'error' => '404',
			'title' => 'Страница не существует',
		];

		header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		
        return $data;
    }

}
