<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:views {names*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание нескольких файлов вьюх';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $names = $this->argument('names');
        foreach ($names as $name) {
            $path = resource_path("views/{$name}.blade.php");
            if (!File::exists($path)) {
                File::ensureDirectoryExists(dirname($path));
                File::put($path, "<!-- Вьюха: {$name} -->");
                $this->info("Создан файл: {$path}");
            } else {
                $this->warn("Файл уже существует: {$path}");
            }
        }

        return Command::SUCCESS;
    }
}
