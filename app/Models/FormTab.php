<?php

namespace App\Models;
use App\Models\FormFieldsModel;
use Illuminate\Database\Eloquent\Model;

class FormTab extends Model
{
   protected $table = 'form_tab';

   public function formField()
{
    return $this->belongsTo(FormFieldsModel::class, 'id', 'tab_id');
}
}
