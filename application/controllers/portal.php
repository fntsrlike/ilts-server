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

    public function oauth_process($provider = 'google')
    {
        # TODO: Check if this provider has setted before

        # TODO: Google Provider

        # TODO: Check if user has registered or not
        #       If yes, redirect to personal page
        #       If not, redirect to register page

    }

    public function register()
    {
        # TODO: If login and has registered, redirect to personal page

        # TODO: Register Form
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