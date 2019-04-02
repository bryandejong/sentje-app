<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionRequest extends Model
{
    public $totalSent = 0;
    public $totalPaid = 0;

    public function users(){
        return $this->belongsToMany('App\User', 'transaction_users', 'users_id' ,
            'transaction_requests_id', '')
            ->withPivot('paid')
            ->withTimestamps();
    }

    public function bankAccount(){
        return $this->hasOne('App\BankAccount');
    }

    public function sender(){
        return $this->hasOne('App\User', 'id', 'sender_id');
    }

    public function canClose(){
        if($this->totalPaid == 0){
            return true;
        } else {
            return false;
        }

    }
}
