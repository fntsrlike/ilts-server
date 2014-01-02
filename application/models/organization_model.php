<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization_model extends CI_Model {

    public function create_organ($oName, $oParentId, $oSortNumber, $oStatus)
    {
        $insertArr = array( 'oName'         => $oName,
                            'oParentId'     => $oParentId,
                            'oSortNumber'   => $oSortNumber,
                            'oStatus'       => $oStatus,
            );

        $this->db->insert('organ_tree', $insertArr);
    }

    public function update_organ($oId, $oName, $oParentId, $oSortNumber, $oStatus)
    {
        $updateArr = array( 'oName'         => $oName,
                            'oParentId'     => $oParentId,
                            'oSortNumber'   => $oSortNumber,
                            'oStatus'       => $oStatus,
            );

        $this->db->where('oId = ', $oId);
        $this->db->update('organ_tree', $updateArr);
    }

    public function read_organ($oId)
    {
        $this->db->where('oId = ', $oId);
        return $this->db->get('organ_tree')->row();
    }

    public function delete_organ($oId)
    {
        $this->db->where('oId = ', $oId);
        $this->db->delete('organ_tree');
    }

    public function list_lower($oId)
    {
        $this->db->where('oParentId = ', $oId);
        $this->db->order_by('oSortNumber', 'as  c');
        return $this->db->get('organ_tree')->result();
    }

    public function list_helper($oId)
    {
        $arr = $this->list_lower($oId);

        $str = '';
        if ($oId == 0)
            $str .= "<ul id=\"tree\" class=\"tree\">";
        else
            $str .= "<ul>";

        foreach ($arr as $row) {
            $str .= "<li> <a class=\"update_organ\" href=\"#\" oid=\"{$row->oId}\" data-toggle=\"modal\" data-target=\"#updateMenu\">({$row->oId}) {$row->oName} </a>";
            $lower = $this->list_lower($row->oId);
            if (!empty($lower)) {
                $str .= $this->list_helper($row->oId);
            }
            $str .= "</li>";
        }
        $str .= "</ul>";

        return $str;

    }

}

/* End of file organization_model.php */
/* Location: ./application/models/organization_model.php */
