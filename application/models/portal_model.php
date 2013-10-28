<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal_model extends CI_Model {

    public function create_user($name, $status)
    {
        $insert = '';
        $insert['uName'] = $name;
        $insert['uStatus'] = $status;

        $this->db->insert('user_list', $insert);
    }   

    public function create_user_oauth($uid, $provider, $identify_value)
    {
        switch (strtolower($provider)) {
            case 'google':
                $type = 1;
                break;
            
            default:
                $type = 0;
                break;
        }

        $insert = '';
        $insert['uId'] = $uid;
        $insert['uOAuthType'] = $type;
        $insert['uOAuthValue'] = $identify_value;

        $this->db->insert('user_oauth', $insert);
    } 

}

/* End of file portal_model.php */
/* Location: ./application/models/portal_model.php */