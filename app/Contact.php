<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //

    protected $fillable = [
        'name', 'email', 'address', 'company','phone', 'group_id', 'user_id'
    ];

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
