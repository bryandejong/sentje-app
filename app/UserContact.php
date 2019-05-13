<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function contact()
    {
        return $this->hasOne('App\User', 'id', 'contact_id');
    }
}
