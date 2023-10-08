<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // Если имя таблицы не соответствует имени модели во множественном числе, вы можете установить его вручную:
    protected $table = 'admins';

    // Определите поля, разрешенные для массового присвоения
    protected $fillable = ['admin_key'];

    // Если у вас есть поля типа даты/времени, кроме created_at и updated_at, вы можете добавить их здесь
    //protected $dates = ['другие_даты'];

}
