<?php

namespace mms80\TodoApi;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['user_id','title','description','status'];

    public const OPEN = 1;
    public const CLOSE = 2;
    public static $enum = [
        Self::OPEN =>'open',
        Self::CLOSE =>'close'
    ];

    public static function toString(int $enum){
        if(array_key_exists($enum,self::$enum)){
            return self::$enum[$enum];
        }
        return 'undifined';
    }

    public function labels(){
        return $this->belongsToMany(Label::class);
    }
}
