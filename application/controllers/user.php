<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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
    }

    public function index()
    {
        $this->list_all();
    }

    public function list_all()
    {

        $users = $this->user_model->list_all();

        $this->load->library('table');
        $table = array();
        $this->table->set_template(array('table_open' => '<table class="table">'));
        $this->table->set_heading('使用者ID', '使用者名稱', '狀態', '註冊時間', '登入提供者');

        foreach ($users as $row) {
            $provider = '';
            foreach ($row->provider as $row2) {
                $provider .= '<span class="label label-primary">' . "{$row2[0]} / {$row2[1]}" . '</span> ';
            }

            switch ($row->status) {
                case '0':
                    $row->status = '正常';
                    break;

                default:
                    $row->status = '異常';
                    break;
            }

            $row->name = "<a href=\"user/user_info/{$row->name}\">$row->name</a>";

            $table[] = array($row->id, $row->name, $row->status, $row->created, $provider);
        }

        $data['table'] = $this->table->generate($table);;

        $this->load->view('header');
        $this->load->view('user/list_all', $data);
        $this->load->view('footer');
    }

    public function user_info($username) {

        $user     = $this->user_model->read_user_by_name($username);
        $identify = $this->identify_model->read_identify_by_uId($user->uId);
        $provider = $this->user_model->get_provider($user->uId);

        foreach ($provider as $key => $value) {
            $data['provider'] = "[{$value[0]}: {$value[1]}]";
        }

        switch ($user->uStatus) {
            case '0':
                $user->uStatus = '正常';
                break;

            default:
                $user->uStatus = '異常';
                break;
        }

        $table = array();
        $this->table->set_template(array('table_open' => '<table class="table"'));
        $this->table->set_heading('Identify id', 'Organization', 'Level', 'Created Time');

        foreach ($identify as $row) {
            $isOrgan = $this->organization_model->read_organ($row->oId);
            if(empty($isOrgan)) {
                $organ = 'Null';
            }
            else {
                $organ = $this->organization_model->read_organ($row->oId)->oName . " ({$row->oId})";
                $organ = '<a href="' . base_url("identify/manage/{$row->oId}") . '">' . $organ . '</a>';
            }

            $operator = '<button type="button" iid="'. $row->iId .'"class="btn btn-danger identRemove">Link</button>';
            $table[] = array($row->iId, $organ, $row->iLevel, $row->iCreateTime);
        }


        $data['id'] = $user->uId;
        $data['username']   = $username;
        $data['status']     = $user->uStatus;
        $data['register']   = $user->uCreateTime;
        $data['provider']   = $data['provider'];
        $data['table']  = $this->table->generate($table);

        $this->load->view('header');
        $this->load->view('user/user_info', $data);
        $this->load->view('footer');
    }

    public function api_read_user() {
        $this->input->post('id');

    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */