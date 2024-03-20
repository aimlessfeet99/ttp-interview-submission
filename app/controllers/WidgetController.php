<?php 

class WidgetController extends BaseController
{
    public function index()
    {
        return View::make('widgets.index');
    }
}

?>