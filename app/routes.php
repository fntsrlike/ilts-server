<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('before' => 'guest_only'), function()
{
    Route::get('login' , function()
    {
        return Redirect::route('login');
    });

    Route::get('portal' , function()
    {
        return Redirect::route('login');
    });

    Route::get('portal/login', array( 'uses' => 'PortalController@login',
                                      'as'   => 'login'));

    Route::get('portal/o/{provider?}', array( 'uses' => 'PortalController@oauth',
                                              'as'   => 'provider'));

    Route::group(array('before' => 'oauth_only'), function()
    {
        Route::get('portal/login_process', array( 'uses' => 'PortalController@login_process',
                                                  'as'   => 'process'));

        Route::get('portal/register', array( 'uses' => 'PortalController@register',
                                             'as'   => 'register'));

        // Route::post('portal/register', array( 'uses' => 'PortalController@register',
        //                                       'as'   => 'register_process',
        //                                      'before' => 'csrf'));

        Route::post('portal/register', array( 'uses' => 'PortalController@register_process',
                                              'as'   => 'register_process',
                                              'before' => 'csrf'));
    });
});

Route::group(array('before' => 'auth_only'), function()
{
    Route::get('portal/user', array( 'uses' => 'PortalController@user',
                                     'as' => 'user', function()
    {
        var_dump(Session::get('user_being'));
    }));

    Route::get('portal/logout', array(  'uses' => 'PortalController@logout',
                                        'as'   => 'logout'));
});

Route::group(array('before' => 'admin_only'), function()
{
    Route::get('ilt' , function()
    {
        return 'ilt page';
    });
});

    Route::get('test', array( 'uses' => 'PortalController@test',
                                         'as'   => 'test'));