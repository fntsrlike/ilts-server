<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function create($uId, $comment)
    {
        $array = array('uId' => $uId, 'adminComment' => $comment);
        $this->db->insert('admin_list', $array);
    }

    public function read($uId)
    {
        $this->db->where('uId = ', $uId);
        $query = $this->db->get('admin_list');

        return $query->row();
    }

    public function read_list()
    {
        $query = $this->db->get('admin_list');

        return $query->result();
    }

    public function update($uId, $comment)
    {
        $array = array('adminComment = ', $comment);
        $this->db->where('uId =', $uId);
        $this->db->update('admin_list', $array);
    }

    public function delete($uId)
    {
        $this->db->where('uId = ', $uId);
        $this->db->delete('admin_list');
    }

}

/* End of file identify_model.php */
/* Location: ./application/models/identify_model.php */