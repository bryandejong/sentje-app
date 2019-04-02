<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    public function transactions(){
        return $this->belongsToMany('App\TransactionRequest');
    }

    public function user(){
        return $this->hasOne('App\User','user_id');
    }

}
