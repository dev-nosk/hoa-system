<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefFieldsModel;
use App\Models\FormsModel;
use App\Models\FormTab;

class FormFieldsModel extends Model
{
    protected $table = 'form_fields';

    // 1 form_field has 1 ref_field
    public function refField()
    {
        return $this->hasOne(RefFieldsModel::class, 'id', 'field_id');
    }

    // form_fields belongs to a form
    public function form()
    {
        return $this->belongsTo(FormsModel::class, 'form_id', 'id');
    }

    public function tab(){
        return $this->hasOne(FormTab::class, 'id', 'field_id');
    }
}
