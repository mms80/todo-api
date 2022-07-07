<?php

namespace mms80\TodoApi;
use \UserModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

if (class_exists('UserModel')) {
    class UserParent extends UserModel { }
} else {
    class UserParent extends Authenticatable { 
        use Notifiable;
    }
}

?>