<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserWorkgroupModel;
use App\Models\FormWorkgroupModel;
use App\Models\FormsModel;

class WorkgroupModel extends Model
{
    protected $connection= 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'workgroup';

    public function form(){
        return $this->hasMany(FormWorkgroupModel::class, 'workgroup_id', 'id');
    }
    public function forms()
{
    return $this->belongsToMany(
        FormsModel::class,
        'form_workgroup',     // pivot table
        'workgroup_id',
        'form_id'
    );
}

    # 1 workgroup has many user_workgroup
    public function userWorkgroup()
    {        return $this->hasMany(UserWorkgroupModel::class, 'workgroup_id', 'id');    

    }
}
    