<?php

namespace Database\Seeders;

use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Text;
use App\Models\User;
class UsersGenresCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Джон Ватсон',
            'email' => 'john.watson@example.com',
            'password' => Hash::make('password123'),
            'role' => 'editor',
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);

        User::create([
            'name' => 'Ваш любимый админ',
            'email' => 'admin@ad.com',
            'password' => Hash::make('111'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);

        User::create([
            'name' => 'Ник Кэрроуэй',
            'email' => 'nick.carraway@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);

        User::create([
            'name' => 'Гумберт Гумберт',
            'email' => 'humbert.humbert@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
            'remember_token' => null,
        ]);

        // Создаем жанры
        Genre::create(['name' => 'Ужасы']);
        Genre::create(['name' => 'Мелодрама']);
        Genre::create(['name' => 'Комедия']);
        Genre::create(['name' => 'Триллер']);
        Genre::create(['name' => 'Драма']);
        Genre::create(['name' => 'Романтика']);
        Genre::create(['name' => 'Приключенческий']);
        Genre::create(['name' => 'Сатира']);
        Genre::create(['name' => 'Криминал']);
        Genre::create(['name' => 'Детская литература']);
        Genre::create(['name' => 'Фантастика']);

        // Создаем категории
        Category::create(['name' => 'Магия']);
        Category::create(['name' => 'Перерождение']);
        Category::create(['name' => 'Альтернативная вселенная']);
        Category::create(['name' => 'Дружба']);
        Category::create(['name' => 'Любовь']);
        Category::create(['name' => 'Трагедия']);
        Category::create(['name' => 'Семейные отношения']);
        Category::create(['name' => 'Секреты и интриги']);
    }
    
}
