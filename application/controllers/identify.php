<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Identify extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ( false == $this->session->userdata('uid')) {
            redirect(base_url('portal/'));
        }
        else if ( 'admin' != $this->session->userdata('level')){
            redirect(base_url('page/no_permission'));
        }

        $this->load->model('identify_model');
        $this->load->model('user_model');
        $this->load->model('organization_model');
        $this->load->library('table');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->list_all();
    }

    public function list_all()
    {
        $users = $this->identify_model->list_all();

        $table = array();
        $this->table->set_template(array('table_open' => '<table class="table"'));
        $this->table->set_heading('Identify id', 'User', 'Organization', 'Level', 'Created Time');

        foreach ($users as $row) {
            $operator = '<button type="button" iid="'. $row->id .'"class="btn btn-danger identRemove">Link</button>';
            $table[] = array($row->id, $row->user, $row->org, $row->level, $row->created);
        }

        $data['table'] = $this->table->generate($table);;

        $this->load->view('header');
        $this->load->view('identify/list_all', $data);
        $this->load->view('footer');
    }

    public function manage($oId)
    {
        $data['organ']  = empty($oId) ? "Null": "{$this->organization_model->read_organ($oId)->oName}";
        $data['oId']    = $oId;

        $this->load->view('header');
        $this->load->view('identify/manage', $data);
        $this->load->view('footer');
    }

    public function organ_ident_list($oId)
    {
        $group = $this->identify_model->list_organ_identifty($oId);

        $table = array();

        $this->table->set_template(array('table_open' => '<table class="table"'));
        $this->table->set_heading('Identify id', 'User', 'Level', 'Created Time', 'Operator');

        foreach ($group as $row) {
            $u_id = $this->user_model->read_user($row->uId);
            $u_id = empty($u_id) ? 'Null' : '<a href="' . base_url("user/user_info/{$u_id->uName}") . '">' . $u_id->uName . " ({$row->uId})</a>";

            $i_id = $row->iId;


            $operator = '<button type="button" iid="'. $i_id .'"class="btn btn-danger identRemove">Delete</button>';
            $table[] = array($i_id, $u_id, $row->iLevel, $row->iCreateTime, $operator);
        }

        echo $data['table']  = $this->table->generate($table);
    }

    public function put_process()
    {
        $arr = array();
        $arr['status']  = 'null';

        if ($this->form_validation->run('identify_put') == false) {
            $arr['status']  = 'failed';
            $arr['err_msg'] = validation_errors();;
        }
        else {
            $u_id   = $this->user_model->read_user_by_name($this->input->post('name'))->uId;
            $o_id   = $this->input->post('oId');
            $level  = $this->input->post('level');

            if ($u_id == null) {
                $arr['status']  = 'failed';
            }
            else {
                $this->identify_model->create_identify($u_id, $o_id, $level);
                $arr['status']  = 'success';
            }
        }

        exit(json_encode($arr));

    }

    public function set_process()
    {
        $i_id   = $this->input->post('iid');
        $u_id   = $this->input->post('uid');
        $o_id   = $this->input->post('oid');
        $level  = $this->input->post('level');

        $this->identify_model->create_identify($i_id, $u_id, $o_id, $level);
    }

    public function del_process()
    {
        $i_id   = $this->input->post('id');

        $this->identify_model->delete_identify($i_id);
    }

}

/* End of file identify.php */
/* Location: ./application/controllers/identify.php */