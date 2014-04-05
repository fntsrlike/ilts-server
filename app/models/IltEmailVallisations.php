<?php
class IltEmailVallisations extends Eloquent {

    protected $table        = 'ilt_email_vallidations';
    protected $primaryKey   = 'id';
    protected $guarded      = array('id');
    protected $softDelete   = true;

}