<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Identify_model extends CI_Model {

    public function list_all()
    {
        $this->load->model('portal_model');
        $this->load->model('organization_model');

        $this->db->order_by('iId','asc');
        $result = $this->db->get('identify_tag')->result();
        $user_obj_arr = array();

        foreach ($result as $row) {
             $user = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);

             $user->id      = $row->iId;
             $user->user    = $this->portal_model->read_user($row->uId)->uName  . " ({$row->uId})";
             $user->org     = $this->organization_model->read_organ($row->oId)->oName . " ({$row->oId})";
             $user->level   = $row->iLevel;
             $user->status  = $row->iStatus;
             $user->created = $row->iCreateTime;

             $user_obj_arr[] = $user;
        }

        return $user_obj_arr;        

    }

    public function create_identify($uId, $oId, $level, $status = '0')
    {
        $insertArr['uId']       = $uId;
        $insertArr['oId']       = $oId;
        $insertArr['iLevel']    = $level;
        $insertArr['iStatus']   = $status;

        $this->db->insert('identify_tag', $insertArr);
    }

}

/* End of file identify_model.php */
/* Location: ./application/models/identify_model.php */