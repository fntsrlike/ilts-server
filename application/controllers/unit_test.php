<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_test extends CI_Controller {

    public function index()
    {
        
    }

    public function oauth_test($provider = 'google')
    {
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->load->spark('oauth2/0.4.0');

        $provider = $this->oauth2->provider($provider, array(
            'id' => '819973222086-qe881vnlq3t75u4oclsh28nj097fp8eq.apps.googleusercontent.com',
            'secret' => 'VBwKNdZkFWmCuj5yp6WBFrBJ',
        ));

        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $url = $provider->authorize();

            redirect($url);
        }
        else
        {
            try
            {
                // Have a go at creating an access token from the code
                $token = $provider->access($_GET['code']);

                // Use this object to try and get some user details (username, full name, etc)
                $user = $provider->get_user_info($token);

                // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
                // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
                echo "<pre>Tokens: ";
                var_dump($token);

                echo "\n\nUser Info: ";
                var_dump($user);
            }

            catch (OAuth2_Exception $e)
            {
                show_error('That didnt work: '.$e);
            }

        }   
    }

    public function portal_model_test($action = '')
    {
        $this->load->model('portal_model');

        switch ($action) {
            case 'create':
                $this->portal_model->create_user('peter', '1');
                $this->portal_model->create_user_oauth('1', 'Google', 'swl@gmail.com');
                break;
            
            case 'read':
            default:
                echo '$this->portal_model->read_user(\'99\')';
                var_dump($this->portal_model->read_user('99'));
                
                echo '$this->portal_model->read_user_oauth(\'1\',\'google\')';
                var_dump($this->portal_model->read_user_oauth('1','google'));
                
                echo '$this->portal_model->read_user_oauth_by_provider(\'google\', \'swl@gmail.com\'';
                var_dump($this->portal_model->read_user_oauth_by_provider('google', 'swl@gmail.com'));
                break;
        }
        
        echo 'finished!';
    }

    public function organization_model_test($action)
    {
        $this->load->model('organization_model');

        switch ($action) {
            case 'create':
                $this->organization_model->create_organ('owo', '0', '0', '8');
                break;
            
            case 'update':
                $this->organization_model->update_organ('1', '=p', '2', '4', '8');
                break;

            case 'read':
                echo '$this->organization_model->read_organ(\'1\')';
                var_dump($this->organization_model->read_organ('1'));
                break;

            case 'list':
                   $list = $this->organization_model->list_organ();
                   var_dump($list);
                   break;   

            default:
                # code...
                break;
        }

        echo 'finished!';
    }

}

/* End of file unit_test.php */
/* Location: ./application/controllers/unit_test.php */