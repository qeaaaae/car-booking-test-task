<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ComfortCategory;
use Illuminate\Database\Seeder;

class ComfortCategorySeeder extends Seeder
{
    /**
     * @var array<int, array{name: string, level: int}>
     */
    private const CATEGORIES = [
        ['name' => 'Класс A', 'level' => 1],
        ['name' => 'Класс B', 'level' => 2],
        ['name' => 'Класс C', 'level' => 3],
        ['name' => 'Класс D', 'level' => 4],
    ];

    public function run(): void
    {
        foreach (self::CATEGORIES as $category) {
            ComfortCategory::query()
                ->updateOrCreate(
                    ['level' => $category['level']],
                    $category,
                );
        }
    }
}
