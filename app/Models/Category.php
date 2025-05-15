<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'texts_count'];

    public function texts()
    {
        return $this->hasMany(Text::class);
    }
}

