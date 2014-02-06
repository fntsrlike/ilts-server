<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization extends CI_Controller {

    public function __construct() {

        parent::__construct();

        if ( false == $this->session->userdata('uid')) {
            redirect(base_url('portal/'));
        }
        else if ( 'admin' != $this->session->userdata('level')){
            redirect(base_url('page/no_permission'));
        }

        $this->load->model('organization_model');
        $this->load->library('form_validation');

    }


    public function index()
    {
        $this->manage();
    }

    public function manage()
    {
        $data = array();
        $this->load->view('header');
        $this->load->view('organization/manage',$data);
        $this->load->view('footer');
    }

    public function tree()
    {
        $data['tree'] = $this->organization_model->list_helper(0,2);
        $this->load->view('organization/tree',$data);
    }

    public function get_files($oId)
    {
        $obj = $this->organization_model->read_organ($oId);
        echo json_encode($obj);
    }

    public function put_process()
    {
        $arr = array();
        $arr['status']  = 'null';

        if ($this->form_validation->run('organ_put') == false) {
            $arr['status']  = 'failed';
            $arr['err_msg'] = validation_errors();;
        }
        else {
            $name   = $this->input->post('name');
            $parent = $this->input->post('parent');
            $sort   = $this->input->post('sort');

            $this->organization_model->create_organ($name, $parent, $sort, '0');

            $arr['status']  = 'success';
        }

        exit(json_encode($arr));
    }

    public function set_process()
    {
        if ($this->form_validation->run('set') == FALSE) {
            $id     = $this->input->post('id');
            $name   = $this->input->post('name');
            $parent = $this->input->post('parent');
            $sort   = $this->input->post('sort');

            $this->organization_model->update_organ($id, $name, $parent, $sort, '0');

            exit('true');
        }
        else {
            exit('false');
        }
    }

    public function del_process()
    {
        $id     = $this->input->post('id');
        $this->organization_model->delete_organ($id);
    }

}

/* End of file organization.php */
/* Location: ./application/controllers/organization.php */