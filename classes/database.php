<?

class database {

    private $host = '127.0.0.1';
    private $login = 'root';
    private $password = '';
    private $db = 'task';
    private $link;
    
    private $sender;
    private $insert_id;
    private $num_rows;
    private $query_count = 0;
    private $query_text;
    private $table;
    private $order = [];
    
    private static $instance = null;

    public static function get_instance() {
        if (self::$instance == null) {
            self::$instance = new database();
        }

        return self::$instance;
    }

    private function __construct($host = null, $login = null, $password = null, $db = null) {
        $this->login = ($login != null) ? $login : $this->login;
        $this->password = ($password != null) ? $password : $this->password;
        $this->host = ($host != null) ? $host : $this->host;
        $this->db = ($db != null) ? $db : $this->db;

        $this->link = mysqli_connect($this->host, $this->login, $this->password, $this->db) or die('Construct class \'database\' error. Connect error ' . mysqli_connect_errno() . ': ' . mysqli_connect_error());
        mysqli_set_charset($this->link, 'utf8');
    }

    public function __destruct() {
        mysqli_close($this->link);
    }
	
	private function my_htmlspecialchars($string) {
		$string = str_replace('"', '&quot;', $string);
		$string = str_replace('\'', '&#039;', $string);
		$string = str_replace('<', '&lt;', $string);
		$string = str_replace('>', '&gt;', $string);
		
		return $string;
	}
	
    public function escape($param, $tags = true, $html = false) {
        $param = (!$tags) ? strip_tags($param) : $param;//tags == true - не обрезать теги
        $param = (!$html) ? $this->my_htmlspecialchars($param) : $param;//html == true - не преобразовывать html-сущности
        $param = trim($param);
        $param = mysqli_real_escape_string($this->link, $param);

        return $param;
    }
    
    public function num_rows() {
        return $this->num_rows;
    }

    public function insert_id() {
        return $this->insert_id;
    }

    public function query_count() {
        return $this->query_count;
    }

    public function query_text() {
        return $this->query_text;
    }

    public function query($q) {
        $this->sender = mysqli_query($this->link, $q);
        
        if (!is_object($this->sender) and $this->sender == true) {
            $this->insert_id = $this->link->insert_id;
        } else {
            $this->num_rows = $this->sender->num_rows;
        }

        if ($this->sender == false) {
            die('Database error #' . $this->link->errno . ': ' . $this->link->error . '<br>Query text: ' . $q . '<br>');
        }

        $this->query_count++;

        return $this->sender;
    }
	
	//Для сложных запросов
	public function manually($q) {
		$this->query_text = $q;
		
		return $this;
	}

    public function select($table, $fields = '*') {
		$this->table = $table;
		
        if ($fields == '*') {
            $this->query_text = "SELECT * FROM `" . $table . "`";
        } else {
            $fields = preg_replace("/(\w+)/iu", "`$1`", $fields);
            $this->query_text = "SELECT " . $fields . " FROM `" . $table . "`";
        }
        
        return $this;
    }

    public function update($table, $array) {   
        foreach ($array as $field => $value) {
            $result .= '`' . $field . '` = \'' . $this->escape($value) . '\', '; 
        }
        
        $result = substr($result, 0, -2);
        
        $this->query_text = "UPDATE `" . $table . "` SET " . $result;
        
        return $this;
    }

    public function insert($table, $array) {
        foreach ($array as $field => $value) {
            $result .= '`' . $field . '` = \'' . $this->escape($value) . '\', '; 
        }
        
        $result = substr($result, 0, -2);
        
        $this->query_text = "INSERT INTO `" . $table . "` SET " . $result;
        
        return $this;
    }

    public function delete($table) {
        $this->query_text = "DELETE FROM `" . $table . "`";

        return $this;
    }

    public function where($param, $value, $operand = '=') {
        switch ($operand) {
            case 'LIKE_%':
                $this->query_text .= " WHERE `" . $this->escape($param) . "` " . 'LIKE' . " '" . $this->escape($value) . "%'";
                break;
            case 'LIKE%%':
                $this->query_text .= " WHERE `" . $this->escape($param) . "` " . 'LIKE' . " '%" . $this->escape($value) . "%'";
                break;
            case 'LIKE%_':
                $this->query_text .= " WHERE `" . $this->escape($param) . "` " . 'LIKE' . " '%" . $this->escape($value) . "'";
                break;
            case 'LIKE':
                $this->query_text .= " WHERE `" . $this->escape($param) . "` " . 'LIKE' . " '" . $this->escape($value) . "'";
                break;

            default:
                $this->query_text .= " WHERE `" . $this->escape($param) . "` " . $operand . " '" . $this->escape($value) . "'";
        }
         
        return $this;
    }
	
	public function whereIn($param, $array) {
		foreach ($array as $field => $value) {
            $result .=  "'" . $this->escape($value) . "'" . ', '; 
        }
        
        $result = substr($result, 0, -2);
        
        $this->query_text .= " WHERE `" . $this->escape($param) . "` IN (" . $result . ")";
        
        return $this;
	}
    
    public function _and($param, $value, $operand = '=') {
        switch ($operand) {
            case 'LIKE_%':
                $this->query_text .= " AND `" . $this->escape($param) . "` " . 'LIKE' . " '" . $this->escape($value) . "%'";
                break;
            case 'LIKE%%':
                $this->query_text .= " AND `" . $this->escape($param) . "` " . 'LIKE' . " '%" . $this->escape($value) . "%'";
                break;
            case 'LIKE%_':
                $this->query_text .= " AND `" . $this->escape($param) . "` " . 'LIKE' . " '%" . $this->escape($value) . "'";
                break;
            case 'LIKE':
                $this->query_text .= " AND `" . $this->escape($param) . "` " . 'LIKE' . " '" . $this->escape($value) . "'";
                break;

            default:
                $this->query_text .= " AND `" . $this->escape($param) . "` " . $operand . " '" . $this->escape($value) . "'";
        }
        
        return $this;
    }

    public function _or($param, $value, $operand = '=') {
        switch ($operand) {
            case 'LIKE_%':
                $this->query_text .= " OR `" . $this->escape($param) . "` " . 'LIKE' . " '" . $this->escape($value) . "%'";
                break;
            case 'LIKE%%':
                $this->query_text .= " OR `" . $this->escape($param) . "` " . 'LIKE' . " '%" . $this->escape($value) . "%'";
                break;
            case 'LIKE%_':
                $this->query_text .= " OR `" . $this->escape($param) . "` " . 'LIKE' . " '%" . $this->escape($value) . "'";
                break;
            case 'LIKE':
                $this->query_text .= " OR `" . $this->escape($param) . "` " . 'LIKE' . " '" . $this->escape($value) . "'";
                break;

            default:
                $this->query_text .= " OR `" . $this->escape($param) . "` " . $operand . " '" . $this->escape($value) . "'";
        }
        
        return $this;
    }

	//$by == ['field' => 'order']
	public function order($by) {
		$this->query_text .= " ORDER BY ";
		$this->order = $by;
			
		foreach ($by as $field => $order) {
			$this->query_text .= $field . "";
			$this->query_text .= ($order == 'ASC') ? " ASC," : " DESC,";
		}
		
		$this->query_text = substr($this->query_text, 0, -1);
		
		return $this;
	}
	
	public function group($by) {
		$this->query_text .= " GROUP BY " . $by . "";
		
		return $this;
	}

    public function limit($limit) {
        $this->query_text .= " LIMIT " . $limit . "";

        return $this;
    }
	
    public function get_row($param = false) {
        $temp = ($param) ? $param : $this->sender;

        if (@is_object($temp)) {
            return mysqli_fetch_object($temp);
        } else {
            die('Function get_row() error: param \'' . $param . '\' is ' . gettype($param) . ', must be object');
        }
    }
    
    public function get_data() {
        $data = [];

        for ($i = 0; $i < $this->num_rows; $i++) {
            $data[$i] = mysqli_fetch_object($this->sender);
        }

        return $data;
    }

    public function apply() {
        return $this->query($this->query_text);
    }

    public function get() {
        $this->query($this->query_text);
        $result = (!is_object($this->sender)) ? $this->sender : $this->get_data($this->sender);

        return $result;
    }
	
	public function first() {
		$this->query($this->query_text);
		
		return mysqli_fetch_object($this->sender);
	}
	
	public function paginate($limit = 5, $page = false) {
		$page = ($page) ? $page : intval($_GET['page']) or $page = 1;
		//Получаем количество страниц
		$notes_count = $this->select($this->table)->apply()->num_rows;
		$page_count = ceil($notes_count / $limit);
		
		if (empty($this->order)) {
			$this->order = ['id' => 'ASC'];
		}
		
		$notes = $this->select($this->table)->order($this->order)->limit($limit * ($page - 1) . ',' . $limit)->get();
		
		$last = $page_count;
		
		$first_prev = ($page - 1 > 1) ? $page - 1 : false;
		$second_prev = ($page - 2 > 1) ? $page - 2 : false;

		$first_next = ($page + 1 < $last) ? $page + 1 : false;
		$second_next = ($page + 2 < $last) ? $page + 2 : false;
		
		
		$result = (object)[
			'notes' => $notes,
			'pages' => (object)[
				'first_prev' => $first_prev,
				'second_prev' => $second_prev,
				'first_next' => $first_next,
				'second_next' => $second_next,
				'current' => $page,
				'last' => $last,
			]
		];
		
		return $result;
	}
    
}

function db() {
    return database::get_instance();
}
