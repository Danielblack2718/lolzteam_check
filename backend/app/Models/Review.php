<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'short_desc',
        'desc',
        'author',
        'time',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
