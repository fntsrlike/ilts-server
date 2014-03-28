<?php

class UserController extends BaseController {

    protected $layout = 'master';

    public function __construct() {
        Form::macro('bs_text', function($label, $name, $id, $placeholder, $default="")
        {
            return <<<_END
            <div class="form-group">
              <label for="{$id}" class="col-sm-2 control-label">{$label}</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" name="{$name}" id="{$id}" placeholder="{$placeholder}" value="{$default}">
              </div>
            </div>
_END;
        });

        Form::macro('bs_area', function($label, $name, $id, $placeholder, $default="")
        {
            return <<<_END
            <div class="form-group">
              <label for="{$id}" class="col-sm-2 control-label">{$label}</label>
              <div class="col-sm-10">
                  <textarea class="form-control" name="{$name}" id="{$id}" placeholder="{$placeholder}>
                    {$default}
                  </textarea>
              </div>
            </div>
_END;
        });
    }

    public function index()
    {
        $user = IltUser::find(Session::get('user_being.u_id'));
        $user_option = IltUserOptions::find(Session::get('user_being.u_id'));

        $data['provider']    = Session::get('user_being.provider');
        $data['user']        = $user;
        $data['user_option'] = $user_option;
        $date['is_developer']= in_array('DEVELOPER', Session::get('user_being.authority') );


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