<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posts_model extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $primary_key = 'id';
    protected $fillable = ['content','customer_id'];
    function tags() {
        return $this->belongsToMany(tags_model::class, 'tags_posts' , 'post_id', 'tag_id');
    }

    function customers() {
        return $this->hasOne(Customer_model::class, 'id', 'customer_id');
    }
}
