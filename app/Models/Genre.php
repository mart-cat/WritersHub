<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name', 'texts_count'];

    public function texts()
    {
        return $this->belongsToMany(Text::class, 'genre_text');
    }
}
