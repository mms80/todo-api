<?php

namespace mms80\TodoApi;
use \UserModel;

class User extends UserModel
{
    protected $fillable = [
        'name', 'email', 'password','token'
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
