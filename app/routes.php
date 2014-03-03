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


# Filter：訪客專區。只有訪客可以看的路由，已登入的使用者訪問本區則直接轉到使用者頁面。
Route::group(array('before' => 'guest_only'), function()
{

    ## 登入頁面
    Route::get('login' ,  function() { return Redirect::route('login');});
    Route::get('portal' , function() { return Redirect::route('login'); });
    Route::get('portal/login', array( 'uses' => 'PortalController@login',
                                      'as'   => 'login'));

    ## Provider OAuth程序
    Route::get('portal/o/{provider?}', array( 'uses' => 'PortalController@oauth',
                                              'as'   => 'provider'));


    # Filter：OAuth專區。只有已經被Provider認可且建立Seesion的使用者可以訪問的頁面
    Route::group(array('before' => 'oauth_only'), function()
    {
        ## 登入程序
        Route::get('portal/login_process', array( 'uses' => 'PortalController@login_process',
                                                  'as'   => 'process'));

        ## 註冊頁面
        Route::get('portal/register', array( 'uses' => 'PortalController@register',
                                             'as'   => 'register'));

        ## 註冊程序
        Route::post('portal/register', array( 'uses' => 'PortalController@register_process',
                                              'as'   => 'register_process',
                                              'before' => 'csrf'));
    });
});


# Filter：使用者專區。只有訪客可以看的路由，已登入的使用者訪問本區則直接轉到使用者頁面。
Route::group(array('before' => 'auth_only'), function()
{
    ## 使用者頁面
    Route::get('portal/user', array( 'uses' => 'UserController@info', 'as' => 'user', function()
    {
        var_dump(Session::get('user_being'));
    }));

    ## 登出程序
    Route::get('portal/logout', array(  'uses' => 'PortalController@logout',
                                        'as'   => 'logout'));


    # Filter：管理者專區。只有已登入的管理者可以看的路由，其餘者訪問本區直接轉入使用者頁面，
    Route::group(array('before' => 'admin_only'), function()
    {
        Route::get('ilt' , function()
        {
            return 'ilt page';
        });
    });

});


