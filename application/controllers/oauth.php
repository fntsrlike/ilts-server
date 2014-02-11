<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class oauth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('oauth_model');
        header('X-XRDS-Location: ' . base_url('oauth/page/header'));
    }

    public function index()
    {
        echo '<h2>hello, world</h2><pre>';
        var_dump($this->session->all_userdata());
        echo '</pre>';
    }

    public function hi()
    {
        echo '<h2>hi</h2>';
    }

    public function bye()
    {
        echo '<h2>bye</h2>';
        echo 'All Sessoins are destroy.';
        $this->session->sess_destroy();
    }

    public function page($code)
    {
        $switch = array('header'           => 'oauth/services.xrds.php',
                        'client_not_exist' => 'oauth/client_not_exist',
                        'auth_no_key'      => 'oauth/key_empty',        );

        if (array_key_exists($code, $switch))
            $this->load->view($switch[$code]);
        else
            $this->load->view('oauth/err');
    }

    public function register()
    {
        #TODO: 另外寫成Controller掌管API註冊管理事宜。

        $key        = $this->oauth_model->generateKey(true);
        $secret     = $this->oauth_model->generateKey();
        $redirect   = 'http://localhost/fntsr/nchusg/rs/rs_ilt/oauth/client';
        $name       = 'MyClient';
        $describe   = 'Just Testing';
        $uId        = 13;

        $this->oauth_model->create_client_register ($key, $secret, $redirect, $name, $describe, $uId);

        echo <<<_END
        <p><strong>Save these values!</strong></p>
        <p>Consumer key: <strong>{$key}</strong></p>
        <p>Consumer secret: <strong>{$secret}</strong></p>
_END;
    }

    private function client($token = '')
    {
        # TODO: 另外寫成Library，讓CodeIgniter與Native PHP都能使用。

        define('OAUTH_HOST',    'http://localhost/fntsr/nchusg/rs/rs_ilt/oauth/');
        define('CLIENT_KEY',    '8cc9a5b4fd37c3131245e396510b23f3052fa41d1');
        define('CLIENT_SECRET', 'c1ebe77b17c1e3700fa6b6e4c82dedad');
        define('CLIENT_URL',    'http://localhost/fntsr/nchusg/rs/oauth_sever/client');
        define('RETURN_URL',    'http://localhost/fntsr/nchusg/rs/oauth_sever/client');
        define('CLIENT_ARGU',   CLIENT_KEY . '/' . md5(CLIENT_SECRET));

        $callback_url['auth_srv']  = OAUTH_HOST . 'auth_srv';
        $callback_url['res_srv']   = OAUTH_HOST . 'res_srv';
        $callback_url['res_owner'] = OAUTH_HOST . 'res_owner';

        $client_session = $this->session->userdata('client');
        $is_client_login = $client_session['status'] != false;

        if (!empty($token) && !$token == "" ) {
            $this->session->set_userdata(array('token'=> $token));
        }

        if ($is_client_login) {
            echo '~';
            header('Location: ' . prep_url(RETURN_URL) );
        }
        else {

            $has_token = $this->session->userdata('token') != false;

            if ($has_token) {
                # FLOW: (D) Access Token -> res_srv()
                $token        = $this->session->userdata('token');
                $token_md5    = md5($this->session->userdata('token'));
                $resource_url = $callback_url['res_srv'] . '/' . $token . '/' . CLIENT_ARGU;
                $data_json = file_get_contents($resource_url);
                $data_arr  = json_decode($data_json);

                $session_data = $data_arr;

                $this->session->set_userdata($session_data);
                $this->session->set_userdata( array( 'client' => array('status' => true) ) );
                echo 'ya!';

                header('Location: ' . prep_url(RETURN_URL) );
            }
            else {

                $is_get_token = (!empty($token)) && (!$token == false);

                if (!$is_get_token) {
                    # FLOW: (A) Authorization Request -> auth_srv()

                    header('Location: ' . prep_url($callback_url['auth_srv'] . '/' . CLIENT_KEY));
                }
                else {
                    $token_cookies['token'] = $token;
                    $this->session->set_userdata($token_cookies);

                    redirect(CLIENT_URL);
                }
            }
        }

    }

    // Authorization Sever
    public function auth_srv($clientKey = '')
    {
        # TODO: 與Ilt系統登入做銜接。

        # ToBe Clear: 與登入系統銜接前，系統測試用緩衝資料。
        $session_data = array('uId' => 13, 'status' => 'true');
        $this->session->set_userdata($session_data);

        # TODO: 確認Ilt系統Session建立的Spec。
        $is_ilt_login = $this->session->userdata('status') != false;

        if (!$is_ilt_login) {

            // 用Session記錄ClientKey，讓轉移來回時仍能保存。會在使用後消除。
            $session_data['auth_srv']['client_key'] = $clientKey;
            $this->session->set_userdata($session_data);

            # TODO: 到時候要去改一下Portal的銜接部分
            $call_back_argu = md5(auth_srv);
            $login_url    = base_url('portal/login/' . $call_back_argu);

            // 轉去Ilt的登入頁面
            header('Location: ' . prep_url($login_url));
        }
        else {

            $is_key_empty = (empty($clientKey) || $clientKey == '');


            if ($is_key_empty) {

                // 若Session有儲值則取出使用，若無則轉移到提示頁面。
                $is_session_args_empty = (false == $this->session->userdata('auth_srv'));

                if($is_session_args_empty) {
                    redirect(base_url('auth_no_key')); exit;
                }
                else {
                    $args = $this->session->userdata('auth_srv');
                    $client_key = $args['client_key'];

                    // 消除session，避免污染、減低從公用電腦盜用的可能
                    $this->session->unset_userdata('auth_srv');
                }
            }

            // ClientKey的存在性，若無此ClientKey，則轉移到提示頁面。
            $is_client_exist = $this->oauth_model->read_is_client_exist($clientKey);

            if (!$is_client_exist) {
                redirect(base_url('oauth/page/client_not_exist')); exit;
            }
            else {
                # TODO: 強化安全性，增加來Client來源網址是否正常的判斷。

                # TODO: 同前提，確認Session Spec
                $uId = $this->session->userdata('uId');
                $client = $this->oauth_model->read_client($clientKey);

                // 確認access token是否存在或在有效期限，亦即該client是否擁有使用者的有效授權
                // 若有，則給予Client Token；若無，則轉移到使用者授權同意頁面。
                $has_confirm = $this->oauth_model->read_user_access_client($uId, $client->client_id);

                if ($has_confirm) {
                    # FLOW: (C) Access Token -> client()

                    $token = $this->oauth_model->read_token_by_user_client_id($uId, $client->client_id);
                    $client_url = $client->redirect_uri;

                    # TODO: token放在網址有其風險性，未來需要強化安全性。
                    // 轉移到Client希望轉移的網址，並且附上token
                    header('Location: ' . prep_url($client_url . '/' . $token));
                }
                else {
                    # FLOW: (A) Authorization Request -> res_owner()

                    // 用Session記錄ClientKey，讓轉移來回時仍能保存。會在後段使用後消除。
                    $session_data['auth_srv']['client_key'] = $clientKey;
                    $this->session->set_userdata($session_data);

                    $res_owner_url = base_url('oauth/res_owner');

                    # TODO: 以client id取代client key。
                    // 轉移到授權頁面，並附上clientKey，讓頁面知道是哪個Client。
                    header('Location: ' . prep_url($res_owner_url . '/' . $clientKey . '/' . 'auth_srv'));
                }
            }

        }
    }

    # TODO: 增加Scope到參數裡
    // Resource Owner
    public function res_owner($clientKey = "", $callbackArgu = "" )
    {
        # FLOW: (B) Authorization Grant -> auth_srv()

        // 因為CodeIgniter URI改制，不是用get取得參數，造成讀取網址會出錯，改成傳參數並在此端轉成網址。
        $callback_url = $this->oauth_model->read_callback_url($callbackArgu);

        // 確認ClientKey是否存在對應的Client。
        $is_client_exist = $this->oauth_model->read_is_client_exist($clientKey);

        if ($is_client_exist) {

            # TODO: 同前提，確認Session Spec
            $uId = $this->session->userdata('uId');
            $client = $this->oauth_model->read_client($clientKey);

            // 確認是否已有有效Access Token，避免重複拿取。若有就轉回callback網址，通常是Authorization Server
            $is_allow_before = $this->oauth_model->read_user_access_client($uId, $client->client_id);

            if ($is_allow_before) {
                header('Location: ' . prep_url($client->redirect_uri));
            }
            else {

                // 檢查是否收到表單Post信息，若無則轉成確認頁面，若有則開始處理。
                $is_get_response = $this->input->post('request_submit');

                if (!$is_get_response) {

                    # TODO: Require的部分要另外製作Spec，並用Model處理。
                    $require = array('讀取是否已經在伊爾特系統登入。');
                    $icon = '<span class="glyphicon glyphicon-check"></span> ';

                    // 處理需求，轉換成文字，未來考慮改以JS處理文字，讓後端專心伺服器部分。
                    $require_list = '';
                    foreach ($require as $key => $value) {
                        $require_list .= "<p>{$icon}{$value}</p>";
                    }

                    # TODO: 補上作者資訊、應用程式描述、token的有效期限
                    $data['action']     = base_url("oauth/res_owner/{$clientKey}/{$callbackArgu}");
                    $data['app_name']   = $client->client_name;
                    $data['require']    = $require_list;

                    $this->load->view('oauth/cofirm_client', $data);
                }
                else {

                    // 使用者是否同意授權，若同意及產生Token回傳callback，若反對則傳回原應用程式位置
                    $is_allow = $this->input->post('request_answer') == "true";
                    if ($is_allow) {
                        $token = md5($this->oauth_model->generateKey(true));
                        $this->oauth_model->create_access_token ($token, $uId, $client->client_id);

                        // 轉移至 CallBack Uri，通常是Authorization Server
                        header('Location: ' . prep_url($callback_url));
                    }
                    else {
                        $client_url = $client->redirect_uri;

                        // 轉移到應用程式位置
                        header('Location: ' . prep_url($client_url));
                    }
                }
            }

        }
    }

    // Resource Server
    public function res_srv($token = '', $clientKey, $SecretMd5)
    {
        // status: 1 => success
        // status: 2 => token expired
        // status: 3 => no token
        $result = array('status' => '', 'data' => '');

        // 確認是否有收到Token
        $is_get_token = !empty($token);

        if (!$is_get_token) {
            $result['status'] = 3;
            $result['data']   = 'We got no token, please';
        }
        else {

            // 確認Token是否過期，若過期僅回報狀態碼，不在這裡處理。那是Authorization Server專司之事。
            $is_token_expired = $this->oauth_model->read_token_expired_check($token);

            if ($is_token_expired) {
                $result['status'] = 2;
                $result['data']   = 'token_expired!';
            }
            else {

                # FLOW: (E) Protected Resource -> client()

                # TODO: 根據scope給予相對應資料，這邊也需要Model協助處理。
                $this->load->model('user_model');
                $uId = $this->oauth_model->read_user_id_by_token($token);
                $user = $this->user_model->read_user($uId);
                $data[] = $user;

                $result['status'] = 1;
                $result['data']   = $data;
            }

        }

        echo json_encode($result);
    }



}