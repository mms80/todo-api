<?php

namespace mms80\TodoApi;
use mms80\TodoApi\UserParent;

class User extends UserParent
{
    protected $fillable = [
        'name', 'email', 'password','token'
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
