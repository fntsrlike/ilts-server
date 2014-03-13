<?php

class API_ClientController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $client = new OAuthClient;
        $client->where('client_owner_uid', '=', Session::get('user_being.u_id'));
        return Response::json($client->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array();
        return View::make('developer/client/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));

        $rules = array(
                'input_client_name' => 'required|unique:oauth_clients,client_name',
                'input_describe'     => 'required',
                'input_from_uri'    => 'required',
                'input_redirect_uri'=> 'required'
                );

        $messages = array(
                'input_client_name.required'    => '「應用程式名稱」是必填欄位！',
                'input_client_name.unique'      => '「應用程式名稱」已經被申請過了！',
                'input_describe.required'        => '「應用程式敘述」是必填欄位！',
                'input_from_uri.required'       => '「應用程式來源白名單」是必填欄位！',
                'input_redirect_uri.required'   => '「應用程式轉向白名單」是必填欄位！',
                );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::action('API_ClientController@create')->withErrors($validator)->withInput();
        }
        else {
            $client = new OAuthClient;
            $client->client_key     = OAuthClient::generateKey(true);
            $client->client_secret  = OAuthClient::generateKey();
            $client->client_owner_uid   = Session::get('user_being.u_id');
            $client->client_name        = Input::get('input_client_name');
            $client->client_describe    = Input::get('input_descibe');
            $client->from_uri           = Input::get('input_from_uri');
            $client->redirect_uri       = Input::get('input_redirect_uri');
            $client->save();
            return Redirect::to('API_ClientController@index');
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
        $client = new OAuthClient;
        return Response::json($client->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data['client'] = OAuthClient::find($id);
        return View::make('developer/client/edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //exit("required|unique:oauth_clients,client_name,$id,client_id");
        $this->beforeFilter('csrf', array('on' => 'post'));

        $rules = array(
                'client_name' => "required|unique:oauth_clients,client_name,{$id},client_id",
                'client_describe'     => 'required',
                'from_uri'    => 'required',
                'redirect_uri'=> 'required',
                );

        $messages = array(
                'client_name.required'    => '「應用程式名稱」是必填欄位！',
                'client_name.unique'      => '「應用程式名稱」已經被申請過了！',
                'client_describe.required'        => '「應用程式敘述」是必填欄位！',
                'from_uri.required'       => '「應用程式來源白名單」是必填欄位！',
                'redirect_uri.required'   => '「應用程式轉向白名單」是必填欄位！',
                );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::action('API_ClientController@edit', $id)->withErrors($validator)->withInput();
        }
        else {
            $client = OAuthClient::find($id);
            $client->client_name        = Input::get('client_name');
            $client->client_describe    = Input::get('client_describe');
            $client->from_uri           = Input::get('from_uri');
            $client->redirect_uri       = Input::get('redirect_uri');
            $client->save();
            return Redirect::action('API_ClientController@index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $client = OAuthClient::find($id);
        $client->delete();
    }

}