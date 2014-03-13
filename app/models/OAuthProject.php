<?php
class OAuthProject extends Eloquent {

    protected $table        = 'oauth_projects';
    protected $primaryKey   = 'project_id';
    protected $guarded      = array('project_id');

}