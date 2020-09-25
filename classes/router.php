<?

class router {

    private static $instance = null;
    private $page = 'tasks';
    private $action = null;

	 public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new router();
        }

        return self::$instance;
    }

    private function __construct() {
	$pre_path = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);		
	$replace = ($pre_path == '/') ? $pre_path : '';		
	$path = str_replace($pre_path, $replace, $_SERVER['REQUEST_URI']);

	if ($path[0] == '/') {
		$path = substr($path, 1);
	}

        //Удаляем последний слэш, если он есть
        if ($path[strlen($path) - 1] == '/') {
            $path = substr($path, 0, -1);
        }
		
		$pages = explode('/', $path);
		
		//Если не пустой первый элемент массива и он не равен page, то это новый контроллер
        if (!empty($pages[0]) and preg_match('/\?/umis', $pages[0]) == 0) {
            $this->page = $pages[0];
		}
		
		//Если не пустой второй элемент массива, то это новое действие
        if (!empty($pages[1])) {
            $this->action = $pages[1];
        } else {
            $this->action = false;
        }
		
		//Если страница не существует, подключаем 404
        if (!file_exists(DOCUMENT_ROOT . '/core/templates/' . $this->page . '.php')) {
            $this->page = '404';
            //header('HTTP/1.1 404 Not Found');
            //header("Status: 404 Not Found");
        }
    }

	public function run() {
        //Подключаем модель шаблона, она есть всегда
        include_once(DOCUMENT_ROOT . '/core/models/model_template.php');
        //Подключаем модель страницы, если она существует
        if (file_exists(DOCUMENT_ROOT . '/core/models/model_' . $this->page . '.php')) {
            $model = 'model_' . $this->page;
            include_once(DOCUMENT_ROOT . '/core/models/' . $model . '.php');
        }

        //Создаем контроллер и запускаем
        $controller = new controller();
        $controller->run($this->page, $model, $this->action);
    }

}

function router() {
    return router::get_instance();
}
