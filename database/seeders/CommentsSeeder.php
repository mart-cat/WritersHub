<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::create([
            'text_id' => 1,
            'user_id' => 1,
            'content' => 'Отличная статья! Очень полезная информация.',
            'parent_id' => null,
        ]);
        
        Comment::create([
            'text_id' => 1,
            'user_id' => 2,
            'content' => 'Спасибо за ваш труд! Было интересно читать.',
            'parent_id' => null,
        ]);
        
        Comment::create([
            'text_id' => 1,
            'user_id' => 3,
            'content' => 'Согласен, жду продолжения',
            'parent_id' => 2,
        ]);
        
        Comment::create([
            'text_id' => 2,
            'user_id' => 2,
            'content' => 'Очень интересный взгляд на тему!',
            'parent_id' => null,
        ]);

        Comment::create([
            'text_id' => 2,
            'user_id' => 1,
            'content' => 'Не совсем согласен с некоторыми пунктами, но в целом неплохо.',
            'parent_id' => 4,
        ]);
        
        Comment::create([
            'text_id' => 2,
            'user_id' => 3,
            'content' => 'Классная статья! Жду продолжения.',
            'parent_id' => null,
        ]);
        
        Comment::create([
            'text_id' => 1,
            'user_id' => 1,
            'content' => 'Спасибо за полезную информацию!',
            'parent_id' => null,
        ]);
        
        Comment::create([
            'text_id' => 1,
            'user_id' => 2,
            'content' => 'Очень хорошо написано. Всё понятно и по делу.',
            'parent_id' => null,
        ]);
        
        Comment::create([
            'text_id' => 1,
            'user_id' => 3,
            'content' => 'Интересно! Хотелось бы узнать больше деталей.',
            'parent_id' => null,
        ]);
        
    }
}
