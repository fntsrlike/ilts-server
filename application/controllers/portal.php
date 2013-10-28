<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portal extends CI_Controller {

    public function index()
    {
        $this->oauth();
    }

    public function oauth()
    {
        # TODO: Check Session.

        # TODO: Just a html Page can go to oauth_process
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

                $this->load->model('portal_model');
                $token = $provider->access($_GET['code']);
                $user = $provider->get_user_info($token);
                
                $user_oauth = $this->portal_model->read_user_oauth_by_provider($provider_type, $user['email']);
                
                if ( empty($user_oauth) ) {
                    $session_data['provider']       = 'Google';
                    $session_data['identify_value'] = $user['email'];

                    $this->session->set_userdata($session_data);

                    redirect(base_url('portal/register'));
                }
                else {
                    $session_data['uid'] = $this->portal_model->read_user($user_oauth->uid);;

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
        $this->load->view('portal/register', $data);
    }

    public function register_process()
    {
        # TODO: If no Special POST argument, redirect to oauth page.
        # TODO: Create Files into DB, and  redirect to personal.
    }

    public function personal_page()
    {
        # TODO: a Page show the user files
    }


}

/* End of file portal.php */
/* Location: ./application/controllers/portal.php */