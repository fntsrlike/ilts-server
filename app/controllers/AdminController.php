<?php

class AdminController extends BaseController {

    protected $layout = 'master';

    public function index()
    {
        $data = array();
        return View::make('admin/info')->with($data);
    }


}