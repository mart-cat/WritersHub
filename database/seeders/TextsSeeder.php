<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Text;
use App\Models\User;
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

        // Данные для текстов
        $textsData = [
            [
                'user' => $watson,
                'title' => 'Дело с последним словом',
                'description' => 'Рассказ о последних днях Шерлока Холмса, рассказываемый его другом, Джоном Ватсоном.',
                'tags' => ['Шерлок Холмс', 'расследование', 'дружба'],
                'status' => 'completed',
                'size' => 'standard',
                'warnings' => '',
                'age_rating' => '12+',
                'dedication' => 'Для моего верного друга Шерлока.',
                'publication_permission' => 'author_only',
                'genres' => [$genreFiction],
                'categories' => [$categoryMystery],
            ],
            [
                'user' => $watson,
                'title' => 'Шерлок и я',
                'description' => 'Собрание самых удивительных историй о Шерлоке Холмсе и его верном друге, докторе Ватсоне.',
                'tags' => ['Шерлок Холмс', 'дружба', 'приключения'],
                'status' => 'in progress',
                'size' => 'maxi',
                'warnings' => '',
                'age_rating' => '16+',
                'dedication' => 'Для самых невероятных приключений.',
                'publication_permission' => 'allowed',
                'genres' => [$genreFiction],
                'categories' => [$categoryAdventure],
            ],
            [
                'user' => $nick,
                'title' => 'Однажды в Нью-Йорке',
                'description' => 'История о том, как события в Нью-Йорке повлияли на судьбы людей.',
                'tags' => ['любовь', 'трагедия', 'дружба'],
                'status' => 'completed',
                'size' => 'mini',
                'warnings' => 'Содержит сцены насилия',
                'age_rating' => '18+',
                'dedication' => 'Для всех потерянных душ, которые нашли друг друга.',
                'publication_permission' => 'author_only',
                'genres' => [$genreDrama],
                'categories' => [$categoryRomance],
            ],
            [
                'user' => $nick,
                'title' => 'Загадка Гэтсби',
                'description' => 'Романтическая история о человеке, который был готов на все ради своей мечты.',
                'tags' => ['любовь', 'мечта', 'жертвенность'],
                'status' => 'in progress',
                'size' => 'standard',
                'warnings' => '',
                'age_rating' => '16+',
                'dedication' => 'Для того, кто все-таки остался в тени.',
                'publication_permission' => 'allowed',
                'genres' => [$genreRomance],
                'categories' => [$categoryRomance],
            ],
            [
                'user' => $humbert,
                'title' => 'Судьба Лолиты',
                'description' => 'История сложных и запретных отношений, основанная на реальных событиях.',
                'tags' => ['любовь', 'запрещенная любовь', 'психология'],
                'status' => 'completed',
                'size' => 'maxi',
                'warnings' => 'Содержит сцены насилия и взрослые темы',
                'age_rating' => '18+',
                'dedication' => 'Для тех, кто поймет.',
                'publication_permission' => 'forbidden',
                'genres' => [$genreRomance],
                'categories' => [$categoryRomance],
            ],
            [
                'user' => $humbert,
                'title' => 'Письма Лолите',
                'description' => 'Собрание писем, написанных Гумбертом Гумбертом своей возлюбленной.',
                'tags' => ['любовь', 'письма', 'психологический триллер'],
                'status' => 'frozen',
                'size' => 'standard',
                'warnings' => 'Содержит сцены насилия и психологические аспекты',
                'age_rating' => '18+',
                'dedication' => 'Для Лолиты, которая никогда не знала моей любви.',
                'publication_permission' => 'author_only',
                'genres' => [$genreDrama],
                'categories' => [$categoryMystery],
            ],
        ];

        // Создание текстов и привязка жанров/категорий
        foreach ($textsData as $data) {
            $text = Text::create([
                'user_id' => $data['user']->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'tags' => json_encode($data['tags']),
                'status' => $data['status'],
                'size' => $data['size'],
                'warnings' => $data['warnings'],
                'age_rating' => $data['age_rating'],
                'dedication' => $data['dedication'],
                'publication_permission' => $data['publication_permission'],
            ]);

            // Привязываем жанры и категории
            $text->genres()->attach(array_map(fn($genre) => $genre->id, $data['genres']));
            $text->categories()->attach(array_map(fn($category) => $category->id, $data['categories']));
        }
    }
}
