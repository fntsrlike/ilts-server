<?php
/**
* 
*/
class OUser
{
    private $id   = null;
    private $username   = null;
    private $nickname   = null;
    private $email      = null;
    private $identify   = null;
    
    public function __construct($user_code = null) {
        if (is_int($user_code)) {
            #TODO: check id exist or not
            $this->id = $user_code;
            #TODO: $this->username = get_username();
        }
        else {
            #TODO: check id exist or not
            $this->username = $user_code;
            #TODO: $this->id = get_id();
        }

        #_initial();
    }

    private function _initial() {

    }

    public function get_id() {

    }

    public function get_username() {

    }

    public function get_nickname() {

    }

    public function set_nickname($strNickname) {

    }

    public function get_email() {

    }

    public function set_email($strEmail) {

    }
    
    public function get_status() {

    }

    public function set_status() {
        
    }

    public function set_status_ban() {

    }

    public function set_status_normal() {

    }

    public function get_identify($intOId) {

    }

    public function set_identify($intOId, $CharOLevel) {
        
    }    

    public function del_identify($intOId) {

    }
    public function list_identify() {

    }

}