<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormStatusModel;

class RepStatusModel extends Model
{
    protected $table = 'ref_status';

    # 1 rep_status has many form_status
    public function formStatus()
    {
        return $this->hasMany(FormStatusModel::class, 'status_id', 'id');
    }
}
