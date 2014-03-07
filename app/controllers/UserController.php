<?php

class UserController extends BaseController {

    protected $layout = 'master';

    public function info()
    {
        $user = IltUser::find(Session::get('user_being.u_id'));
        $user_option = IltUserOptions::find(Session::get('user_being.u_id'));

        $data['provider']    = Session::get('user_being.provider');
        $data['user']        = $user;
        $data['user_option'] = $user_option;
        return View::make('user/info', array('name' => 'user'))->with($data);
    }

}