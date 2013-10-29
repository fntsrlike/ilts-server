<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

    public function index()
    {
        $this->load->view('header');
        //$this->load->view('organization/tree',$data);
        $this->load->view('footer');        
    }

}

/* End of file about.php */
/* Location: ./application/controllers/about.php */