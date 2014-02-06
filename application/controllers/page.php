<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

    }

    public function index()
    {
        $this->about();
    }

    public function about()
    {
        $this->load->view('header');
        $this->load->view('page/about');
        $this->load->view('footer');
    }

    public function no_permission(){
        $this->load->view('header');
        $this->load->view('page/no_permission');
        $this->load->view('footer');
    }

}

/* End of file about.php */
/* Location: ./application/controllers/about.php */