<?php

namespace App\Models;
use App\Models\CategoryModel;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ServiceModel extends Model
{
    protected $table = 't_service';
    protected $fillable = [
        'service_request_at',
        'service_request_by',
        'userTable_length',
        'service_payment_due',
        'service_category_id',
        'created_by',
        'updated_by',
    ];
    # 1 record has 1 user
   public function created_user()
{
    return $this->belongsTo(User::class, 'create_by', 'id');
}

    # 1 record has 1 category
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'service_category_id', 'id');
    }
}
