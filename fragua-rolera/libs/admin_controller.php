<?php
require_once CORE_PATH . 'kumbia/controller.php';
/**
 */
class AdminController extends Controller
{
    final protected function initialize()
    {
        if ( Input::isAjax() ) View::template('');
        else if ($this->controller_name == 'boxes') View::template('boxes');
        else if ($this->controller_name == 'pages') View::template('pages');
        else View::template('admin');
    }

    final protected function finalize()
    {
        
    }
}
