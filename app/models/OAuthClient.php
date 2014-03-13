<?php
class OAuthClient extends Eloquent {

    protected $table        = 'oauth_clients';
    protected $primaryKey   = 'client_id';
    protected $guarded      = array('client_id');


    public static function generateKey ( $unique = false )
    {
        $key = md5(uniqid(rand(), true));

        if ( true === $unique ) {
            list($usec,$sec) = explode(' ',microtime());
            $key .= dechex($usec).dechex($sec);
        }
        return $key;
    }

}