<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {

    public function __construct() {
        parent::__construct();  
        $this->load->model('portal_model');

    }

    public function index()
    {    
        $this->oauth();   
    }

    public function oauth()
    {
        # Check Session.
        if ( !empty($this->session->userdata('uid'))) {
            redirect(base_url('portal/personal_page'));
        }
        
        # Just a html Page can go to oauth_process
        $this->load->view('portal/oauth');
    }

    public function oauth_process($provider_type = 'google')
    {
        # TODO: Google Provider
        $this->load->spark('oauth2/0.4.0');

        $provider = $this->oauth2->provider($provider_type, array(
            'id' => '819973222086-qe881vnlq3t75u4oclsh28nj097fp8eq.apps.googleusercontent.com',
            'secret' => 'VBwKNdZkFWmCuj5yp6WBFrBJ',
        ));

        if ( ! $this->input->get('code'))
        {
            $url = $provider->authorize();
            redirect($url);
        }
        else
        {
            try
            {
        
                $token = $provider->access($_GET['code']);
                $user = $provider->get_user_info($token);
                
                $user_oauth = $this->portal_model->read_user_oauth_by_provider($provider_type, $user['email']);
                
                $session_data['provider']       = 'Google';
                $session_data['identify_value'] = $user['email'];
                
                if ( empty($user_oauth) ) {
                    $this->session->set_userdata($session_data);

                    redirect(base_url('portal/register'));
                }
                else {
                    $session_data['uid'] = $user_oauth->uId;
                    $this->session->set_userdata($session_data);

                    redirect(base_url('portal/personal_page'));
                }

                
            }

            catch (OAuth2_Exception $e)
            {
                show_error('OAuth2 didnt work: '.$e);
            }

        }   

    }

    public function register()
    {
        # If login and has registered, redirect to personal page
        if ( empty($this->session->userdata('provider')) || empty($this->session->userdata('identify_value')) ) {
            redirect(base_url('portal/oauth'));
        }
        elseif ( !empty($this->session->userdata('uid'))) {
            redirect(base_url('portal/personal_page'));
        }

        # Register Form
        $data['form_action'] = base_url('portal/register_process');
        $data['provider_value'] = $this->session->userdata('identify_value');

        $this->load->view('portal/register', $data);
    }

    public function register_process()
    {
        $provider = $this->session->userdata('provider');
        $identify_value = $this->session->userdata('identify_value');

        # If no Special POST argument, redirect to oauth page.
        if ($this->input->post('value') != $identify_value) {
            exit('The process must be something wrong!');
        }

        if ($this->portal_model->read_user_oauth_by_provider($provider, $identify_value)) {
            exit('You have use this provider to register before!');
        }

        # Create Files into DB, and redirect to personal.
        $name = $this->input->post('username');        
        $this->portal_model->create_user($name, 0);

        $uid = $this->db->insert_id();

        $this->portal_model->create_user_oauth($uid, $provider, $identify_value);

        $session_data['uid'] = $uid;
        $this->session->set_userdata($session_data);        

        redirect(base_url('portal'));
    }

    public function personal_page()
    {
        if ( empty($this->session->userdata('uid'))) {
            redirect(base_url('portal/'));
        }

        # Page show the user files
        $provider = $this->session->userdata('provider');
        $identify_value = $this->session->userdata('identify_value');
        $u_id = $this->session->userdata('uid');

        $data['info'] = "iId='$u_id'; provider='$provider'; identify_value='$identify_value'";
        $this->load->view('portal/personal_page', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('portal'));
    }


}

/* End of file portal.php */
/* Location: ./application/controllers/portal.php */