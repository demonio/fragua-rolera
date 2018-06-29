<?php
/**
 */
class BoxesController extends AdminController
{   
	#
    public function before_filter()
    {
        if ( $action = Input::post('action') )
        {
            unset($_POST['action']);
            if ( method_exists($this, $action) ) $this->$action($_POST);
        }
    }

    #
    public function index($box_slug='')
    {
    	$this->boxes = (new Boxes)->readAll();
        $this->dir = empty($_GET['dir']) ? '': $_GET['dir'];
        $this->file = empty($_GET['file']) ? '': $_GET['file'];
        if ( empty($this->box) ) $this->box = (new Boxes)->readOne($box_slug);
    }

    #
    public function create($a)
    {
    	$this->box = (new Boxes)->createOne($a);
    }

    #
    public function update($a)
    {
    	$this->box = (new Boxes)->updateOne($a);
    }

    #
    public function delete($id)
    {
    	(new Boxes)->deleteOne($id);
    	_::go('/admin/boxes');
    }
}
