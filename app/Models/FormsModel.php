<?php

namespace App\Models;
use App\Models\FormFieldsModel;
use App\Models\FormStatusModel;

use Illuminate\Database\Eloquent\Model;

class FormsModel extends Model
{
    protected $connection= 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'forms';

    # 1 form has many form_fields
    public function formFields()
    {
        return $this->hasMany(FormFieldsModel::class, 'form_id', 'id');
    }

    # 1 form belongs to a form_status
    public function formStatus()
    {
        return $this->belongsTo(FormStatusModel::class, 'status_id', 'id');
    }
}
