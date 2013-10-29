<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

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