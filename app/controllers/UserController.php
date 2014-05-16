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
        $u_id = Session::get('user_being.u_id');
        $user = IltUser::find($u_id);
        $user_option = IltUserOptions::find($u_id);
        $user_providers = IltUserProvider::where('u_id', '=', $u_id)->get();
        $user_providers_arr = array();
        $providers = Config::get('sites.providers');
        $providers_info = '';
        $access_clients = OAuthAccessToken::where('user_id', '=', $u_id)->get();
        $project = array();
        $projects_info = '';

        foreach ($user_providers as $user_provider) {
            $user_providers_arr[] = $user_provider->u_p_type;
        }

        foreach ($providers as $provider) {
            if ( in_array($provider, $user_providers_arr) ) {
                $providers_info .= '<li>' . $provider . '：' . '<span class="text-success">已通過</span></li>';
            }
            else {
                $providers_info .= '<li>' . $provider . '：' . '<span class="text-muted">尚未認證</span></li>';
            }
        }

        foreach ($access_clients as $access_client) {
            $client = OAuthClient::where('client_id', '=', $access_client->client_id)->first();
            $project = OAuthProject::find($client->project_id);

            if ( $access_client->expires < time() ) {
                $projects_info .= '<li>' . $project->name . '：' . '<span class="text-success">已通過</span></li>';
            }
            else {
                $projects_info .= '<li>' . $project->name . '：' . '<span class="text-muted">已過期</span></li>';
            }


        }

        $data['provider']       = Session::get('user_being.provider');
        $data['providers_info'] = $providers_info;
        $data['projects_info']  = $projects_info;
        $data['user']           = $user;
        $data['user_option']    = $user_option;
        $date['is_developer']   = in_array('DEVELOPER', Session::get('user_being.authority') );


        return View::make('user/info', array('name' => 'user'))->with($data);
    }

    public function apply_developer()
    {
        $user = IltUser::find(Session::get('user_being.u_id'));

        if ( false !== stripos($user->u_authority, 'DEVELOPER' )) {
            return Redirect::action('DeveloperController@index');
        }

        if(Input::has('agree')) {
            $this->beforeFilter('csrf', array('on' => 'post'));

            $rules      = Config::get('validation.CTRL.user.apply_developer.rules');
            $messages   = Config::get('validation.CTRL.user.apply_developer.messages');
            $validator  = Validator::make(Input::all(), $rules, $messages);

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

                $session['authority'] = explode(',', $user->u_authority);

                if ( !is_array($session['authority']) ) {
                    $session['authority'] = array($session['authority']);
                }

                Session::put('user_being.authority', $session['authority']);

                return Redirect::action('DeveloperController@index');
            }
        }
        else {
            return View::make('developer/terms');
        }
    }

    public function email_vallidate($type, $code) {

        $type = strtoupper($type);
        $user = IltUser::find(Session::get('user_being.u_id'));
        $email_orm = IltEmailVallisations::where('type', '=', $type)
                                     ->where('code', '=', $code)
                                     ->where('expires', '>', date('Y-m-d'))
                                     ->first();

        if ( false !== stripos($user->u_authority, $type )) {
            return View::make('user.email_vallidate_result', array('status' => 'already'));
        }
        elseif ( $email_orm == null ) {
            return View::make('user.email_vallidate_result', array('status' => 'not_found'));
        }
        elseif ( $email_orm->u_id != Session::get('user_being.u_id') ) {
            return View::make('user.email_vallidate_result', array('status' => 'not_match'));
        }

        $email = $email_orm->email;
        $email_orm->delete();

        switch ($type) {
            case 'STUDENT':
                $student = new IltUserStudent;
                $student->u_id       = Session::get('user_being.u_id');
                $student->email      = $email;
                $student->save();
                return Redirect::action('StudentController@apply_files_process');

            default:
                return View::make('user.email_vallidate_result', array('status' => 'success'));
        }

    }


}
