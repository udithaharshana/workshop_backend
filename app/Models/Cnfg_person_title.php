<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cnfg_person_title extends Model
{
    protected $table = 'cnfg_person_titles';
    public $timestamps = false;
    protected $primaryKey = 'tid';

    public function result1()
    {
        return DB::select('select * from cnfg_person_titles where sts="1" ');
    }

}
