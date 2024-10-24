<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // Добавьте этот импорт

class Client extends Model
{
    use HasFactory, Notifiable; // Добавьте Notifiable здесь

    // Определите заполняемые поля
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'city',
        'registered_at',
    ];
}
