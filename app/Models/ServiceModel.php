<?php

namespace App\Models;

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
];
}
