<?php

class OAuthController extends BaseController {

    // protected $layout = 'master';

    public function __construct()
    {
        header('X-XRDS-Location: ' . action('OAuthController@header'));
    }

    public function index()
    {
        return 'oauth index';
    }

    public function auth_server()
    {
        # 登入檢查：已交由router統一處理。

        $client_key = Input::get('client_key');

        // Client Key 檢查
        if ( true == empty($client_key) ) {

            if( true == Session::has('auth_srv.client_key') ) {
                $client_key = Session::get('auth_srv.client_key');
                Session::forget('auth_srv');
            }
            else {
                return Redirect::action('OAuthController@argument_losing');
            }
        }

        $client_query = OAuthClient::where('client_key', '=', $client_key);

        // Client 存在檢查
        if ( 0 == $client_query->count() ) {
            return Redirect::action('OAuthController@client_no_exist');
        }

        $client          = $client_query->first();
        $access_form     = $client->from_uri;
        $access_redirect = $client->redirect_uri;
        $host_uri        = urldecode(Input::get('host_uri'));
        $redirect_uri    = urldecode(Input::get('redirect_uri'));

        // 強化安全性，增加來Client要求轉換的網址是否正常的判斷。
        if ( false === stripos($access_redirect, $redirect_uri) ) {
            exit('redirect_uri not valid');
        }

        $scope       = Input::get('scope');
        $u_id        = Session::get('user_being.u_id');
        $token_query = OAuthAccessToken::where('client_id', '=', $client->client_id)->where('user_id', '=', $u_id);

        if ( 1 == $token_query->count() ) {

            $token = $token_query->first()->access_token;

            # TODO: token放在網址有其風險性，未來需要強化安全性。   // 其實好像還好？

            # TODO: 檢查Scope是否相同，若不相同，則需要重新拿取access token

            // 轉移到Client希望轉移的網址，並且附上token
            if(false === stripos($redirect_uri, '?')) {
                $token_argu = '?token=' . $token;
            }
            else {
                $token_argu = '&token=' . $token;
            }

            return Redirect::to($redirect_uri . $token_argu);
        }
        else {
            // 用Session記錄client_key，讓轉移來回時仍能保存。會在後段使用後消除。
            Session::put('iltOAuth.client_key', $client_key);
            Session::put('iltOAuth.callback', 'auth_server');
            Session::put('iltOAuth.scope', $scope);
            Session::put('iltOAuth.redirect_uri', $redirect_uri);

            # TODO: 以client id取代client key。     // 忘記為啥要這樣做了
            // Code..

            // 轉移到授權頁面，並附上client_key，讓頁面知道是哪個Client。
            return Redirect::action('OAuthController@resource_owner');
        }


    }

    # TODO: 增加Scope到參數裡
    // Resource Owner
    public function resource_owner()
    {
        $iltOAuth        = Session::get('iltOAuth');
        $client_key      = Session::get('iltOAuth.client_key');
        $redirect_method = Session::get('iltOAuth.callback');
        $scope           = Session::get('iltOAuth.scope');
        $expires         = Session::get('iltOAuth.expires', 180);
        $redirect_uri    = Session::get('iltOAuth.redirect_uri');
        $client_query    = OAuthClient::where('client_key', '=', $client_key);
        Session::forget('iltOAuth');

        // Client 存在檢查
        if ( 0 == $client_query->count() ) {
            return Redirect::action('OAuthController@client_no_exist');
        }

        $u_id        = Session::get('user_being.u_id');
        $client      = $client_query->first();
        $project     = OAuthProject::find($client->project_id);

        $token_query = OAuthAccessToken::where('client_id', '=', $client->client_id)->where('user_id', '=', $u_id);

        # TODO: 加入判定條件，檢查Scope是否相同。若是相同且有效才跳回去。

        // 確認是否已有有效Access Token，避免重複拿取。
        if ( 1 == $token_query->count() ) {
            return Redirect::to($client->redirect_uri);
        }

        // 檢查是否收到表單Post信息，若無則轉成確認頁面，若有則開始處理。
        if ( false == Input::has('request_submit') ) {

            // Test
            $scope = 'user.basic+user.files+user.student';

            # TODO: 將Scopes翻譯成Require
            $require = explode('+', $scope);
            $icon = '<span class="glyphicon glyphicon-check"></span> ';

            // 處理需求，轉換成文字，未來考慮改以JS處理文字，讓後端專心伺服器部分。
            $require_list = '';
            foreach ($require as $key => $value) {
                $require_list .= "<p>{$icon}{$value}</p>";
            }

            $manager = IltUser::find($project->developer_id);

            # TODO: 補上作者資訊、應用程式描述、token的有效期限
            $data['app_info']       = "{$manager->u_nick} ({$manager->u_username}) [{$manager->u_email}]";
            $data['app_describe']   = $project->describe;
            $data['action']     = action('OAuthController@resource_owner');
            $data['app_name']   = $project->name;
            $data['require']    = $require_list;

            Session::put('iltOAuth', $iltOAuth);
            return View::make('oauth/cofirm_client', $data);
        }
        else {

            // 使用者是否同意授權，若同意及產生Token回傳callback，若反對則傳回原應用程式位置
            if ( 'true' == Input::get('request_answer' )) {
                $token = md5($this->generateKey(true));

                $access_token = new OAuthAccessToken;
                $access_token->access_token = $token;
                $access_token->client_id    = $client->client_id;
                $access_token->user_id      = $u_id;
                $access_token->expires      = date('Y-m-d', time() + $expires * 24 * 3600);
                $access_token->save();

                Session::put('auth_srv.client_key', $client_key);
                return Redirect::action('OAuthController@'.$redirect_method);
            }
            else {
                return Redirect::to($redirect_uri);
            }
        }

    }

    // Resource Server
    public function resource_server()
    {
        // status: 1 => success
        // status: 2 => token expired
        // status: 3 => arguments losing
        // status: 4 => client identify failed

        $result = array('status' => '', 'data' => '', 'msg' => '');

        // 確認是否有收到Token
        if ((true !== Input::has('token')) ||
            (true !== Input::has('client_key')) ||
            (true !== Input::has('client_secret')) ) {

            $result['status'] = 3;
            $result['msg']    = '您給予的參數有失，請重新發送要求。';
            exit(json_encode($result));
        }


        $token          = Input::get('token');
        $client_key     = Input::get('client_key');
        $client_secret  = Input::get('client_secret');
        $client         = OAuthClient::where('client_key', '=', $client_key)->first();

        // 判定是否為該client
        if ($client->client_secret !== $client_secret) {
            $result['status'] = 4;
            $result['msg']   = 'Client辨識失敗，請重新發送要求。';
            exit(json_encode($result));
        }

        $access_token = OAuthAccessToken::where('access_token', '=', $token)->first();
        $is_token_expired = ( strtotime($access_token->expires) < time() );
        $is_token_expired = false;
        // 確認Token是否過期，若過期僅回報狀態碼，不在這裡處理。那是Authorization Server 專司之事。
        if ($is_token_expired) {
            $result['status'] = 2;
            $result['msg']   = 'Token已經過期，請重新向Authorization Server索取。';
            exit(json_encode($result));
        }

        # TODO: 根據scope給予相對應資料，這邊也需要Model協助處理。
        $user = IltUser::find($access_token->user_id);
        $data[] = $user;

        // 審查全部合格，給予使用者資料
        $result['status'] = 1;
        $result['msg']    = '您已經通過審合，資料已經附上。';
        $result['data']   = $user;
        exit(json_encode($result));
    }

    public function header()
    {

    }

    public function argument_losing()
    {
        return View::make('oauth/argument_losing');
    }

    public function client_no_exist()
    {
        return View::make('oauth/client_no_exist');
    }

    private function generateKey ( $unique = false )
    {
        $key = md5(uniqid(rand(), true));
        if ($unique)
        {
            list($usec,$sec) = explode(' ',microtime());
            $key .= dechex($usec).dechex($sec);
        }
        return $key;
    }

}