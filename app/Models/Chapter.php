<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'text_id',
        'title',
        'content',
        'char_count',
        'page_count',
    ];

    public function text()
    {
        return $this->belongsTo(Text::class);
    }
}
