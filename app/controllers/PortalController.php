<?php

class PortalController extends BaseController {

    protected $layout = 'portal.master';

    public function login(){

        if (Input::has('callback')) {
            Session::put('portal.callback', urldecode(Input::get('callback')));
        }
        else {
            Session::forget('portal.callback');
        }

        $data = array();
        $data['url'] = array('google'   => action('PortalController@oauth', 'google'),
                             'facebook' => action('PortalController@oauth', 'facebook'));

        return View::make('portal/login', array('name' => 'Login'))->with($data);
    }


    public function oauth($action) {

        // check URL segment
        if ($action == "auth") {
            // process authentication
            try {
                Hybrid_Endpoint::process();
            }
            catch (Exception $e) {
                // redirect back to http://URL/social/
                return Redirect::route('provider');
            }
            return;
        }
        try {

            $provider = strtolower($action);
            $providers = array('google', 'facebook');

            if ( !in_array($provider, $providers)) {
                echo 'invalid provider!';
                return;
            }

            // create a HybridAuth object
            $socialAuth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
            // authenticate with Google
            $provider = $socialAuth->authenticate($provider);
            // fetch user profile
            $userProfile = $provider->getUserProfile();

        }
        catch(Exception $e) {
            // exception codes can be found on HybBridAuth's web site
            return $e->getMessage();
        }

        // access user profile data
        $oauth = array(
                    'status'    => true,
                    'provider'  => $provider->id,
                    'user'      => $userProfile);

        Session::put('oauth', $oauth);

        // logout
        $provider->logout();
        return Redirect::action('PortalController@login_process');
    }


    public function login_process() {

        $oauth = (object) Session::get('oauth');

        $provider   = strtolower( $oauth->provider );
        $identifier = $oauth->user->identifier;
        $email      = $oauth->user->email;

        $i_u_p = IltUserProvider::where('u_p_identifier', '=', $identifier)->where('u_p_type', '=', $provider);
        $count = $i_u_p->count();
        $provider = $i_u_p->first();

        if ($count == 0) {
            return Redirect::route('register');
        }

        $user = IltUser::where('u_id', '=', $provider->u_id)->first();

        $session = array(   'status'    => true,
                            'provider'  => $provider->u_p_type,
                            'identifier'=> $identifier,
                            'u_id'      => $user->u_id,
                            'username'  => $user->u_username,
                            'authority' => explode(',', $user->u_authority) ,
                            'level'     => $user->u_status);

        if ( !is_array($session['authority']) ) {
            $session['authority'] = array($session['authority']);
        }

        Session::put('user_being', $session);
        Session::forget('oauth');

        if ( true == Session::has('portal.callback')) {

            $callback = Session::get('portal.callback');
            Session::forget('portal.callback');

            return Redirect::to($callback);
        }

        return Redirect::route('user');
    }

    public function register()
    {
        $oauth = (object) Session::get('oauth');
        $user  = $oauth->user;
        $email = $user->email;
        $username = substr($email, 0, stripos($email, '@'));
        $birthday = $user->birthYear . '/' . $user->birthMonth . '/' . $user->birthDay;

        $session = array(   'provider'  => $oauth->provider,
                            'identifier'=> $oauth->user->identifier,
                            'email'     => $email );

        Session::put('register', $session);

        $default['provider']    = strtolower( $oauth->provider );
        $default['identifier']  = $user->identifier;
        $default['username']    = Input::old('username',$username);
        $default['nickname']    = Input::old('nickname',    $user->displayName);
        $default['email']       = Input::old('email',       $email);
        $default['first_name']  = Input::old('first_name',  $user->firstName);
        $default['last_name']   = Input::old('last_name',   $user->lastName);
        $default['gender']      = Input::old('gender',      $user->gender);
        $default['birthday']    = Input::old('birthday',    $birthday);
        $default['phone']       = Input::old('phone',       $user->phone);
        $default['address']     = Input::old('address',     $user->address);
        $default['website']     = Input::old('website',     $user->webSiteURL);
        $default['description'] = Input::old('description', $user->description);

        $data = array('default' => $default,
                      'action'  => action('register_process') );

        return View::make('portal/register', array('name' => 'register'))->with($data);
    }

    public function register_process()
    {

        $rules = array(
                'username'    => 'required|alpha_dash',
                'nickname'    => 'required',
                'email'       => 'required|email',
                'first_name'  => '',
                'last_name'   => '',
                'gender'      => '',
                'birthday'    => 'date|date_format:Y/m/d',
                'phone'       => 'numeric',
                'address'     => '',
                'website'     => 'url',
                'gravater'    => 'email',
                'description' => ''
                );

        $messages = array(
            'required'      => '本欄位選項是必填的！',
            'alpha_dash'    => '本欄位選項必需為大小寫英文字母（A-Z, a-z）、底線（_）、減號（-）組成。',
            'email'         => '本欄位選項請符合email格式（Ex. foo@bar.com）。',
            'url'           => '本欄位選項請符合網址(url)格式（Ex. http://www.foo.com ）。',
            'numeric'       => '本欄位選項請符合純數字格式。',
            'date'          => '本欄位選項請輸入有效的日期範圍。',
            'date_format'   => '本欄位選項請符合純日期（yyyy/mm/dd）格式。'

        );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return Redirect::to('portal/register')->withErrors($validator)->withInput();
        }
        else {
            $register = (object) Session::get('register');

            $user = new IltUser;
            $user->u_username = Input::get('username');
            $user->u_nick     = Input::get('nickname');
            $user->u_email    = Input::get('email');
            $user->u_status   = 'Guest';
            $user->save();

            $user_opt = new IltUserOptions;
            $user_opt->u_id             = $user->u_id;
            $user_opt->u_first_name     = Input::get('first_name');
            $user_opt->u_last_name      = Input::get('last_name');
            $user_opt->u_gender         = Input::get('gender');
            $user_opt->u_birthday       = Input::get('birthday');
            $user_opt->u_phone          = Input::get('phone');
            $user_opt->u_address        = Input::get('address');
            $user_opt->u_website        = Input::get('website');
            $user_opt->u_gravatar       = Input::get('gravater');
            $user_opt->u_description    = Input::get('description');
            $user_opt->save();

            $provider = new IltUserProvider;
            $provider->u_p_type         = $register->provider;
            $provider->u_p_identifier   = $register->identifier;
            $provider->u_p_email        = $register->email;
            $provider->u_id             = $user->u_id;
            $provider->save();

            Session::forget('oauth');
            Session::forget('register');

            $session = array(   'status'    => true,
                                'provider'  => $register->provider,
                                'identifier'=> $register->identifier,
                                'u_id'      => $user->u_id,
                                'username'  => $user->u_username,
                                'authority' => $user->u_authority,
                                'level'     => $user->u_status);

            Session::put('user_being', $session);

            return Redirect::route('user');
        }

    }

    public function logout() {
        Session::forget('user_being');
        return Redirect::route('login');
    }


}