<?php
/**
 */
class PagesController extends AdminController
{   
	#
    public function before_filter()
    {
        if ( $action = Input::request('action') )
        {
            unset($_REQUEST['action']);
            if ( method_exists($this, $action) ) $this->$action($_REQUEST);
        }
    }

    #
    public function index()
    {
    	$this->boxes = (new Boxes)->readAll();
        #_::d($this->boxes);
        $this->page_boxes = (new Pages)->readBoxes($_GET);
        #_::d($this->page_boxes);

        $this->dir = empty($_GET['dir']) ? '': $_GET['dir'];
        $this->file = empty($_GET['file']) ? '': $_GET['file'];
        $this->ext = empty($this->file) ? '': pathinfo($this->file)['extension'];
        $this->fullpath = dirname(APP_PATH) . $this->dir . $this->file;
        $this->code = file_get_contents($this->fullpath);
        #_::d(str_replace('<', '&lt;',  $this->code));
    }

    #
    public function create($a)
    {
        $p = (new Pages)->createOne($a);
        _::go( "/admin/pages/?" . http_build_query($a) );
    }

    #
    public function read($id)
    {
        View::template('box');

        $this->box = (new Pages)->readOne($id);
        #_::d($this->box);
        #_::go( "/admin/pages/?" . http_build_query($a) );
    }

    #
    public function update($a)
    {
    	$p = (new Pages)->updateOne($a);
        _::go( "/admin/pages/?" . http_build_query($a) );
    }

    #
    public function delete($id)
    {
        (new Pages)->deleteOne($id);
        $url = parse_url($_SERVER['HTTP_REFERER'])['path'];
        $get = '?' . http_build_query($_GET);
    	_::go("$url$get");
    }

    #
    public function create_file($a)
    {
        $b = (new Pages)->createFile($a);
        _::go( "/admin/pages/?dir=$b->dir&file=$b->file");
    }

    #
    public function update_file($a)
    {
        $b = (new Pages)->updateFile($a);
        _::go( "/admin/pages/?dir=$b->dir&file=$b->file");
    }

    #
    public function delete_file($a)
    {
        $dir = (new Pages)->deleteFile($a);
        _::go("/admin/pages/?dir=$dir");
    }

    #
    public function save_variables($a)
    {
        $b = (new Variables)->saveVariables($a);
    }

    #
    public function weight_down($a)
    {
        $b = (new Pages)->weightDown($a);
    }

    #
    public function weight_up($a)
    {
        $b = (new Pages)->weightUp($a);
    }
}
