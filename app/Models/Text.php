<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'genre_id',
        'category_id',
        'tags',
        'status',
        'size',
        'warnings',
        'age_rating',
        'dedication',
        'publication_permission',
    ];

    // Связь с главами
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    // Связь с пользователем (автор текста)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с жанром
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    // Связь с категорией
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_text');
    }

    // Связь с комментариями
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Связь с оценками
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // Связь с избранным
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Связь со статистикой
    public function statistics()
    {
        return $this->hasOne(Statistic::class);
    }
}
