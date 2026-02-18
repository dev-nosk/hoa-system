<?php

namespace App\Models;
use App\Models\FormFieldsModel;

use Illuminate\Database\Eloquent\Model;

class RefFieldsModel extends Model
{
   
 protected $table = 'ref_fields';
public function formField()
{
    return $this->belongsTo(FormFieldsModel::class, 'id', 'field_id');
}
}
