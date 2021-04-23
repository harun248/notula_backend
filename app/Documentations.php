<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentations extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function notula(){
        return $this->belongsTo(Notulas::class);
    }
}
