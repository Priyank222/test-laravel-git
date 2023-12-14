<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\payments;

class Customer_model extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = ['name', 'email','image','password'];

    function payments() {
        return $this->hasMany(payments::class, 'customer_id', 'id');
    }

    function posts() {
        return $this->hasMany(posts_model::class, 'customer_id', 'id');
    }

    function user_likes() {
        return $this->hasManyThrough(likes_model::class,posts_model::class,'customer_id','post_id');
    }
    function user_tags() {
        return $this->hasManyThrough(tags_model::class,posts_tags_model::class,'customer_id');
    }
}
