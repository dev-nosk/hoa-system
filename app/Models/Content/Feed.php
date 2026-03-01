<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Feed extends Model
{
      protected $table = 'feed';
      
      public function user(){
       return $this->belongsTo(User::class,'created_by','id');
      }
}
