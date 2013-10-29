<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Identify extends CI_Controller {

    public function index()
    {
        $this->list_all();
    }

    public function list_all()
    {
        $this->load->model('identify_model');
        $users = $this->user_model->list_all();

        $this->load->library('table');
        $table = array();
        $this->table->set_template(array('table_open' => '<table class="table"'));
        $this->table->set_heading('Identify id', 'User', 'Organization', 'Level', 'Register Time');

        foreach ($users as $row) {
            $table[] = array($row->id, $row->name, $row->status, $row->created, $provider);
        }

        $data['table'] = $this->table->generate($table);;

        $this->load->view('header');
        $this->load->view('identify/list_all', $data);
        $this->load->view('footer');             
    }

}

/* End of file identify.php */
/* Location: ./application/controllers/identify.php */