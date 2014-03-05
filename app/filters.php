<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Custom
|--------------------------------------------------------------------------
|
|
*/

Route::filter('auth_only', function()
{

    // 如果還沒登入，會轉移到登入頁面。

    $is_login = (Session::has('user_being') && Session::get('user_being.status') == true);
    if ( ! $is_login ) {
        $current_uri = urlencode('http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        return Redirect::to( action('PortalController@login') . '?callback=' . $current_uri);
    }
});

Route::filter('admin_only', function()
{

    // 如果不是管理員，會被轉移到使用者主頁。

    $admin_auth = 'ADMIN';
    $authority  = (Session::has('user_being')) ? Session::get('user_being.authority') : '';

    if ( strpos($authority, $admin_auth) == false) {
        return Redirect::route('user');
    }
});

Route::filter('guest_only', function()
{
    // 如果已經登入，會被轉移到使用者主頁

    $is_login = (Session::has('user_being') || Session::get('user_being.status') == true);
    if ( $is_login ) {
        return Redirect::route('user');
    }
});

Route::filter('oauth_only', function()
{
    // 如果沒有provider的資料，會被轉移到登入頁面

    $is_oauth = (Session::has('oauth') || Session::get('oauth.status') == true);
    if ( !$is_oauth ) {
        return Redirect::route('login');
    }
});