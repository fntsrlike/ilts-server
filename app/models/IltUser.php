<?php
class IltUser extends Eloquent {

    protected $table        = 'ilt_users';
    protected $primaryKey   = 'u_id';
    protected $guarded      = array('u_id');

}