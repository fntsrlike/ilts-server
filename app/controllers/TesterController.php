<?php

class TesterController extends BaseController {

    protected $layout = 'portal.master';

    public function make_status_login()
    {
        $user = IltUser::where('u_id', '=', 1)->first();

        $session = array(   'status'    => true,
                            'provider'  => 'google',
                            'identifier'=> '111977102604797957166',
                            'u_id'      => $user->u_id,
                            'username'  => $user->u_username,
                            'authority' => explode(',', $user->u_authority) ,
                            'level'     => $user->u_status);

        Session::put('user_being', $session);

        return Redirect::route('login');

    }
}