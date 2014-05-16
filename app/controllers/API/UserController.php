<?php

class API_UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$user = IltUser::all();
		return Response::json($user);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules      = Config::get('validation.API.user.store.rules');
        $messages   = Config::get('validation.API.user.store.messages');
        $validator  = Validator::make(Input::all(), $rules, $messages);

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

            // Session::forget('oauth');
            // Session::forget('register');

            // $session = array(   'status'    => true,
            //                     'provider'  => $register->provider,
            //                     'identifier'=> $register->identifier,
            //                     'u_id'      => $user->u_id,
            //                     'username'  => $user->u_username,
            //                     'authority' => $user->u_authority,
            //                     'level'     => $user->u_status);

            // Session::put('user_being', $session);

            //return Redirect::route('user');
        }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = IltUser::find($id);
		return Response::json($user);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$user = IltUser::find($id);
    	$user->delete();
	}

}
