<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkgroupModel extends Model
{
    protected $connection= 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'workgroup';


    public function forms(){
        return $this->hasMany('App\Models\Form\Loan\FormWorkgroupModel', 'id', 'workgroup_id');
    }
}
    