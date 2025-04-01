<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'text_id',
        'views',
        'likes',
        'comments_count',
        'favorites_count',
        'average_rating',
    ];

    //Отношение: Статистика принадлежит тексту.
    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}