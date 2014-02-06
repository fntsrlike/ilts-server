<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {


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

    public function read_user($uId)
    {
        $this->db->where('uId = ', $uId);
        return $this->db->get('user_list')->row();
    }

    public function read_user_list()
    {
        $this->db->order_by('uId','asc');
        $result = $this->db->get('user_list')->result();
        $users = array();

        foreach ($result as $row) {

             $user['id']      = $row->uId;
             $user['name']    = $row->uName;
             $user['status']  = ($row->uStatus == 0) ? '正常' : '異常';
             $user['created'] = $row->uCreateTime;
             $user['providers']= $this->get_provider($row->uId);

             $users[] = $user;
        }

        return $users;
    }

    public function read_user_by_name($name)
    {
        $this->db->where('uName = ', $name);
        return $this->db->get('user_list')->row();
    }

    public function read_user_oauth($uId, $provider)
    {
        $type = $this->provide_to_code($provider);

        $this->db->where('uId = ', $uId);
        $this->db->where('uOAuthType = ', $type);
        return $this->db->get('user_oauth')->row();
    }

    public function read_user_oauth_by_provider($provider, $value)
    {
        $type = $this->provide_to_code($provider);

        $this->db->where('uOAuthType = ', $type);
        $this->db->where('uOAuthValue = ', $value);
        return $this->db->get('user_oauth')->row();
    }

    private function provide_to_code($provider)
    {
        switch (strtolower($provider)) {
            case 'google':
                $type = 1;
                break;

            default:
                $type = 0;
                break;
        }

        return $type;
    }


    public function list_all()
    {
        $this->db->order_by('uId','asc');
        $result = $this->db->get('user_list')->result();
        $user_obj_arr = array();

        foreach ($result as $row) {
             $user = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);

             $user->id      = $row->uId;
             $user->name    = $row->uName;
             $user->status  = $row->uStatus;
             $user->created = $row->uCreateTime;
             $user->provider= $this->get_provider($row->uId);

             $user_obj_arr[] = $user;
        }

        return $user_obj_arr;
    }

    public function get_provider($uId)
    {
        $this->db->order_by('uOAuthType', 'asc');
        $result = $this->db->get('user_oauth')->result();

        $provider = array();

        foreach ($result as $row) {
            switch ($row->uOAuthType) {
                case '1':
                    $type = 'Google';
                    break;

                default:
                    $type = 'Unknown';
                    break;
            }
            $provider[] = array($type, $row->uOAuthValue);
        }

        return $provider;
    }

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */