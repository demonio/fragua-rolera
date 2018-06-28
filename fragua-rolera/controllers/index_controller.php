<?php
/**
 */
class IndexController extends AppController
{
	/**
	 */
    public function index()
    {
    	View::template('logo');
        #$this->page_boxes = (new Pages)->readBoxes();
    }
}
