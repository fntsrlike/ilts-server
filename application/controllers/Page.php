<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

    public function index()
    {
        $this->load->view('header');
        $this->load->view('page/main');
        $this->load->view('footer');
    }

    public function about()
    {
        $this->load->view('header');
        $this->load->view('page/about');
        $this->load->view('footer');        
    }

}

/* End of file about.php */
/* Location: ./application/controllers/about.php */