<?php
class OAuthClient extends Eloquent {

    protected $table        = 'oauth_clients';
    protected $primaryKey   = 'client_id';
    protected $guarded      = array('client_id');

}