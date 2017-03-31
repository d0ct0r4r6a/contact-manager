<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //To connect this model to a particular table
    //protected $table="<table_name>"
    protected $fillable = ['name'];
    
    public function contacts()
    {
        return $this->hasMany('App\Contact', 'group_id');
    }
}
