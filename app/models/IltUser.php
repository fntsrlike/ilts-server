<?php
class IltUser extends Eloquent {

    protected $table        = 'ilt_users';
    protected $primaryKey   = 'u_id';
    protected $guarded      = array('u_id');

    // public function scopePopular($query)
    // {
    //     return $query->where('votes', '>', 100);
    // }
    // $users = User::popular()->orderBy('created_at')->get();




}