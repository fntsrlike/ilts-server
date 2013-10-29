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

}

/* End of file organization_model.php */
/* Location: ./application/models/organization_model.php */
