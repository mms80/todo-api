<?php

namespace mms80\TodoApi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Label extends Model
{

    protected $fillable = ['title'];
    
    public function tasks(){
        return $this->belongsToMany(Task::class);
    }

    public function totalTasks(){
        $user = Auth::user();
        return $this->tasks->where('user_id',$user->id)->count();
    }
}
