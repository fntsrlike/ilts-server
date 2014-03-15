<?php

class DeveloperController extends BaseController {

    protected $layout = 'master';

    public function index()
    {
        return View::make('developer/info')->with($data);
    }


}