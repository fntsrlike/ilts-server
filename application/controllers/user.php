<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if ( empty($this->session->userdata('uid'))) {
            redirect(base_url('portal/'));
        }
    }

    public function index()
    {
        $this->list_all();
    }

    public function list_all()
    {
        $this->load->model('user_model');
        $users = $this->user_model->list_all();

        $this->load->library('table');
        $table = array();
        $this->table->set_template(array('table_open' => '<table class="table"'));
        $this->table->set_heading('uId', 'Name', 'Status', 'Register Time', 'Provider');

        foreach ($users as $row) {
            $provider = '';
            foreach ($row->provider as $row2) {
                $provider .= '<span class="label label-primary">' . "{$row2[0]} / {$row2[1]}" . '</span> ';
            }

            $table[] = array($row->id, $row->name, $row->status, $row->created, $provider);
        }

        $data['table'] = $this->table->generate($table);;

        $this->load->view('header');
        $this->load->view('user/list_all', $data);
        $this->load->view('footer');        
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */