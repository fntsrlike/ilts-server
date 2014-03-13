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

    public function apply_developer()
    {
        if(Input::has('agree')) {
            $this->beforeFilter('csrf', array('on' => 'post'));

            $rules = array(
                    'agree'    => 'accepted',
                    );

            $messages = array(
                    'accepted'       => '您必須同意條款才能成為開發者！',
                    );

            $validator = Validator::make(Input::all(), $rules, $messages);

            if ($validator->fails()) {
                return Redirect::action('UserController@apply_developer')->withErrors($validator)->withInput();
            }
            else {
                $user = IltUser::find(Session::get('user_being.u_id'));

                if( empty($user->u_authority) ) {
                    $user->u_authority = 'DEVELOPER';
                }
                else {
                    $user->u_authority .= ',DEVELOPER';
                }

                $user->save();
                Session::put('user_being.authority', $user->u_authority);

                return Redirect::action('DeveloperController@index');
            }
        }
        else {
            return View::make('developer/terms');
        }
    }


}