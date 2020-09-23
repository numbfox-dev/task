<?

class view {

    private static $template_view = 'template'; //Общий вид

    public function create($content_view, $template_data, $data) {
        include_once(DOCUMENT_ROOT . '/core/templates/' . self::$template_view . '.php');
    }

}
