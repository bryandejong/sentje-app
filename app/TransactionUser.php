<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TransactionUser extends Model
{
    protected $fillable = ['paid', 'currency', 'mollie_id'];
    public $incrementing = false;

    public function receiver(){
        return $this->hasOne('App\User', 'id', 'users_id');
    }

    public function request() {
        return $this->hasOne('App\TransactionRequest', 'id', 'transaction_requests_id');
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('users_id', '=', $this->getAttribute('pk_1'))
            ->where('transaction_requests_id', '=', $this->getAttribute('pk_2'));
        return $query;
    }
}
