<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Text;
use App\Models\User;
use Illuminate\Database\Seeder;

class TextsSeeder extends Seeder
{
    public function run(): void
    {
        // Получаем авторов
        $watson = User::where('name', 'Джон Ватсон')->first();
        $nick = User::where('name', 'Ник Кэрроуэй')->first();

        // Получаем жанры и категории
        $genreFiction = Genre::where('name', 'Фантастика')->first();
        $genreDrama = Genre::where('name', 'Драма')->first();

        $categoryAdventure = Category::where('name', 'Альтернативная вселенная')->first();
        $categoryRomance = Category::where('name', 'Любовь')->first();

        // Произведение для Шерлока Холмса
        $text1 = Text::create([
            'user_id' => $watson->id,
            'title' => 'Шерлок и я',
            'description' => 'Собрание самых удивительных историй о Шерлоке Холмсе и его верном друге, докторе Ватсоне.',
            'genre_id' => $genreFiction->id,
            'tags' => json_encode(['Шерлок Холмс', 'дружба', 'приключения']),
            'status' => 'in progress',
            'size' => 'maxi',
            'warnings' => '',
            'age_rating' => '16+',
            'dedication' => 'Для самых невероятных приключений.',
            'publication_permission' => 'allowed',
        ]);

        // Привязываем категории к тексту
        $text1->categories()->attach([$categoryAdventure->id]);

        // Произведение для Ника Кэрроуэя
        $text2 = Text::create([
            'user_id' => $nick->id,
            'title' => 'Однажды в Нью-Йорке',
            'description' => 'История о том, как события в Нью-Йорке повлияли на судьбы людей.',
            'genre_id' => $genreDrama->id,
            'tags' => json_encode(['любовь', 'трагедия', 'дружба']),
            'status' => 'completed',
            'size' => 'mini',
            'warnings' => 'Содержит сцены насилия',
            'age_rating' => '18+',
            'dedication' => 'Для всех потерянных душ, которые нашли друг друга.',
            'publication_permission' => 'author_only',
        ]);

        $text2->categories()->attach([$categoryRomance->id]);
    }
}
