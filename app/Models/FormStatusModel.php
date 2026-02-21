<?php

namespace App\Models;
use App\Models\RepStatusModel;
use App\Models\FormsModel;

use Illuminate\Database\Eloquent\Model;

class FormStatusModel extends Model
{
    protected $table = 'form_status';

    # form_status belongs to a rep_status
    public function repStatus()
    {
        return $this->belongsTo(RepStatusModel::class, 'status_id', 'id');
    }

    # form_status has many forms
    public function forms()
    {
        return $this->hasMany(FormsModel::class, 'status_id', 'id');
    }
}
