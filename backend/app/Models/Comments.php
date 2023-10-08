<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'desc',
        'author',
        'time',
    ];

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }
}
