<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer_model;

class payments extends Model
{
    use HasFactory;
    protected $table = 'payments';

    function customer() {
        return $this->hasOne(Customer_model::class, 'id', 'customer_id');
    }
}
