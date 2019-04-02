<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *n
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function receivedTransactions(){
        return $this->belongsToMany('App\TransactionRequest')
            ->withPivot('paid')
            ->withTimestamps();
    }

    public function sentTransactions(){
        return $this->belongsTo('App\TransactionRequest');
    }

    public function bankAccounts(){
        return $this->belongsToMany('App\BankAccount');
    }

    //Requires explicitly defined foreign keys and intermediate table
    public function contacts(){
        return $this->belongsToMany('App\User', 'user_contacts', 'user_id', 'contact_id');
    }

    //Requires explicitly defined foreign keys and intermediate table
    public function contactOf(){
        return $this->belongsToMany('App\User', 'user_contacts', 'contact_id', 'user_id');
    }

}
