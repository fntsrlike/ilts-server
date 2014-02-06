<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        # Check Session.
        if ( false == $this->session->userdata('uid')) {
            redirect(base_url('portal/user_page'));
        }
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

}

/* End of file about.php */
/* Location: ./application/controllers/about.php */