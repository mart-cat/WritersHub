<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Text;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TextsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем авторов
        $watson = User::where('name', 'Джон Ватсон')->first();
        $nick = User::where('name', 'Ник Кэрроуэй')->first();
        $humbert = User::where('name', 'Гумберт Гумберт')->first();

        // Получаем жанры и категории
        $genreFiction = Genre::where('name', 'Фантастика')->first();
        $genreRomance = Genre::where('name', 'Романтика')->first();
        $genreDrama = Genre::where('name', 'Драма')->first();

        $categoryMystery = Category::where('name', 'Магия')->first();
        $categoryAdventure = Category::where('name', 'Альтернативная вселенная')->first();
        $categoryRomance = Category::where('name', 'Любовь')->first();


                // Произведения для Шерлока Холмса
        Text::create([
            'user_id' => $watson->id,
            'title' => 'Шерлок и я',
            'description' => 'Собрание самых удивительных историй о Шерлоке Холмсе и его верном друге, докторе Ватсоне.',
            'genre_id' => $genreFiction->id,  // Изменено: связь с жанром
            'category_id' => $categoryAdventure->id,  // Изменено: связь с категорией
            'tags' => json_encode(['Шерлок Холмс', 'дружба', 'приключения']),
            'status' => 'in progress',  // Статус
            'size' => 'maxi',
            'warnings' => '',
            'age_rating' => '16+',
            'dedication' => 'Для самых невероятных приключений.',
            'publication_permission' => 'allowed',
        ]);

        // Произведения для Ника Кэрроуэя
        Text::create([
            'user_id' => $nick->id,
            'title' => 'Однажды в Нью-Йорке',
            'description' => 'История о том, как события в Нью-Йорке повлияли на судьбы людей.',
            'genre_id' => $genreDrama->id,  // Изменено: связь с жанром
            'category_id' => $categoryRomance->id,  // Изменено: связь с категорией
            'tags' => json_encode(['любовь', 'трагедия', 'дружба']),
            'status' => 'completed',  // Статус
            'size' => 'mini',
            'warnings' => 'Содержит сцены насилия',
            'age_rating' => '18+',
            'dedication' => 'Для всех потерянных душ, которые нашли друг друга.',
            'publication_permission' => 'author_only',

        ]);

    }
}
