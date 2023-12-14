<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tags_model extends Model
{
    use HasFactory;
    protected $table = 'tags';
    protected $primary_key = 'id';

    function user_tags() {
        return $this->hasManyThrough(Customer_model::class,posts_tags_model::class,'post_id','id','id','tag_id');
    }
}
