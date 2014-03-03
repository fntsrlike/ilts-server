<?php

class UserController extends BaseController {

    protected $layout = 'user.master';

    public function info()
    {
        $data['user'] = (object) Session::get('user_being');
        return View::make('user/info', array('name' => 'user'))->with($data);
    }

}