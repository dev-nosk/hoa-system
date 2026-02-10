<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormsModel extends Model
{
    protected $connection= 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'forms';
}
