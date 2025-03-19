<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'tags', 'status', 'size',
        'warnings', 'age_rating', 'dedication', 'publication_permission'
    ];

    // Связь с пользователем (автор текста)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'tags' => 'array',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_text');
    }

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
