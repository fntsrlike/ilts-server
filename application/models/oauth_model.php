<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oauth_model extends CI_Model {

    public function generateKey ( $unique = false )
    {
        $key = md5(uniqid(rand(), true));
        if ($unique)
        {
            list($usec,$sec) = explode(' ',microtime());
            $key .= dechex($usec).dechex($sec);
        }
        return $key;
    }

    public function read_callback_url($argu)
    {
        $switch = array('auth_srv'   => base_url('oauth/auth_srv'),
                        'res_srv'    => base_url('oauth/src_srv'),
                        'res_owner'    => base_url('oauth/res_owner'),
                        );

        return (array_key_exists($argu, $switch)) ? $switch[$argu] : false;
    }

    public function create_client_register ($key, $secret, $redirect, $name, $describe, $uId)
    {
        $insert_arr = array(
            'client_key'    => $key,
            'client_secret' => $secret,
            'redirect_uri'  => $redirect,
            'client_name'   => $name,
            'client_describe'   => $describe,
            'client_owner_uid'  => $uId
            );

        $this->db->insert('oauth_clients', $insert_arr);
    }

    // public function create_user_access_client ($uId, $clientId)
    // {
    //     $insert_arr = array(
    //         'uId'       => $uId,
    //         'clientId'  => $clientId,
    //         'expired'   => time() + 30 * 24 * 3600
    //         );

    //     $this->db->insert('oauth_user_access', $insert_arr);
    // }

    public function create_access_token ($token, $uId, $clientId)
    {
        $insert_arr = array(
            'access_token'  => $token,
            'user_id'       => $uId,
            'client_id'     => $clientId,
            'scope'         => 'BASIC'
            );

        $this->db->insert('oauth_access_tokens', $insert_arr);
    }

    public function read_client ($key)
    {
        $this->db->where('client_key = ', $key);
        $query = $this->db->get('oauth_clients');

        return $query->row();
    }

    public function read_is_client_exist ($clientKey)
    {
        $this->db->where('client_key = ', $clientKey);
        $query = $this->db->get('oauth_clients');

        return ($query->num_rows() >= 1) ? true : false;

    }

    public function read_user_access_client ($uId, $clientId)
    {
        $this->db->where('user_id = ', $uId);
        $this->db->where('client_id = ', $clientId);
        $this->db->where('expires >= ', time() - 30*24*3600);
        $query = $this->db->get('oauth_access_tokens');

        return ($query->num_rows() >= 1) ? true : false;

    }

    public function read_token_by_user_client_id ($uId, $clientId){
        $this->db->where('user_id = ', $uId);
        $this->db->where('client_id = ', $clientId);
        $this->db->where('expires >= ', time() - 30*24*3600);
        $query = $this->db->get('oauth_access_tokens');

        return ($query->num_rows() >= 1) ? $query->row()->access_token : false;
    }

    public function read_token_expired_check ($token)
    {
        $this->db->where('access_token = ', $token);
        $this->db->where('expires < ', time() - 30*24*3600);
        $query = $this->db->get('oauth_access_tokens');

        return ($query->num_rows() >= 1) ? true : false;
    }

    public function read_user_id_by_token ($token)
    {
        $this->db->where('access_token = ', $token);
        $query = $this->db->get('oauth_access_tokens');

        return ($query->num_rows() >= 1) ? $query->row()->user_id : false;
    }
}