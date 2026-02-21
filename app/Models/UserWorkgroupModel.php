<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWorkgroupModel extends Model
{
   protected $table = 'user_workgroup';
   protected $fillable = [
        'user_id',
        'workgroup_id',
        'created_by',
        'updated_by',
    ];
}
