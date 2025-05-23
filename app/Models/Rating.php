<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'text_id',
        'user_id',
        'rating',
    ];

     // Связь с тексты.
    public function text()
    {
        return $this->belongsTo(Text::class);
    }

     //Связь с пользователи.

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
