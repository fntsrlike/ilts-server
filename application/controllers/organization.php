<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization extends CI_Controller {

    public function __construct() {
        parent::__construct();  
        $this->load->model('organization_model');

    }


    public function index()
    {
        $this->list_all(0);
    }

    public function main()
    {
        # TODO: List organiztion
        $data['tree'] = $this->organization_model->list_helper(0,2);
        $this->load->view('portal/tree',$data);
    }

    public function put_process()
    {
        $name   = $this->input->post('name');
        $parent = $this->input->post('parent');
        $sort   = $this->input->post('sort');

        $this->organization_model->create_organ($name, $parent, $sort, '0');
    }

}

/* End of file organization.php */
/* Location: ./application/controllers/organization.php */