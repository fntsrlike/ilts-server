<?php

class API_ProjectController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $project = new OAuthProject;
        $project->where('developer_id', '=', Session::get('user_being.u_id'));
        return Response::json($project->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = array();
        return View::make('developer/project/create')->with($data);
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
                'name' 			=> 'required|unique:oauth_projects,name',
                'describe'     	=> 'required',
                'email'    		=> 'required',
                );

        $messages = array(
                'name.required'    => '「專案名稱」是必填欄位！',
                'name.unique'      => '「專案名稱」已經被申請過了！',
                'describe.required'=> '「專案敘述」是必填欄位！',
                'email.unique'     => '「電子郵件」是必填欄位！',
                );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::action('API_ProjectController@create')->withErrors($validator)->withInput();
        }
        else {
            $project = new OAuthProject;
            $project->developer_id  		= Session::get('user_being.u_id');
            $project->name 					= Input::get('name');
            $project->describe 				= Input::get('describe');
            $project->email 				= Input::get('email');
            $project->homepage_url 			= Input::get('homepage_url');
            $project->logo_url				= Input::get('logo_url');
            $project->privacy_policy_url 	= Input::get('privacy_policy_url');
            $project->terms_of_service_url 	= Input::get('terms_of_service_url');
            $project->save();

            return Redirect::action('API_ProjectController@index');
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
        $project = new OAuthProject;
        return Response::json($project->find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data['project'] = OAuthProject::find($id);
        return View::make('developer/project/edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
        $rules = array(
                'name' 			=> "required|unique:oauth_projects,name,{$id},project_id",
                'describe'     	=> 'required',
                'email'    		=> 'required',
                );

        $messages = array(
                'name.required'    => '「專案名稱」是必填欄位！',
                'name.unique'      => '「專案名稱」已經被申請過了！',
                'describe.required'=> '「專案敘述」是必填欄位！',
                'email.unique'     => '「電子郵件」是必填欄位！',
                );

        $validator = Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::action('API_ProjectController@edit')->withErrors($validator)->withInput();
        }
        else {
            $project = OAuthProject::find($id);
            $project->developer_id  		= Session::get('user_being.u_id');
            $project->name 					= Input::get('name');
            $project->describe 				= Input::get('describe');
            $project->email 				= Input::get('email');
            $project->homepage_url 			= Input::get('homepage_url');
            $project->logo_url				= Input::get('logo_url');
            $project->privacy_policy_url 	= Input::get('privacy_policy_url');
            $project->terms_of_service_url 	= Input::get('terms_of_service_url');
            $project->save();

            return Redirect::action('API_ProjectController@index');
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
        $project = OAuthProject::find($id);
        $project->delete();
    }

}