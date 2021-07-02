<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    public $timestamps = false;
    protected $primaryKey = 'sid';

    public function title_name(){
        return $this->hasOne('App\Models\Cnfg_person_title','tid','tid');
    }

    public function create_user_name(){
        return $this->hasOne('App\Models\User','id','create_user_id');
    }
    public function update_user_name(){
        return $this->hasOne('App\Models\User','id','update_user_id');
    }
}
