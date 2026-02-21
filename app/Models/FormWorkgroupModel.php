<?php

namespace App\Models;
use App\Models\WorkgroupModel;

use Illuminate\Database\Eloquent\Model;

class FormWorkgroupModel extends Model
{
    protected $connection= 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'form_workgroup';

    # 1 form_workgroup belongs to a workgroup
    public function workgroup()
    {        
        return $this->belongsTo(WorkgroupModel::class, 'workgroup_id', 'id');

    }
}
