<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ComfortCategory;
use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * @var array<string, array<int, string>>
     */
    private const POSITIONS = [
        'Менеджер по продажам' => ['Класс B', 'Класс C'],
        'Директор по операционной деятельности' => ['Класс A', 'Класс B'],
        'Исполнительный помощник' => ['Класс C', 'Класс D'],
        'Генеральный директор' => ['Класс A'],
    ];

    public function run(): void
    {
        $categories = ComfortCategory::query()
            ->pluck('id', 'name');

        foreach (self::POSITIONS as $name => $allowedCategories) {
            $position = Position::query()
                ->updateOrCreate(['name' => $name]);

            $position->comfortCategories()->sync(
                collect($allowedCategories)
                    ->map(fn (string $categoryName) => $categories[$categoryName] ?? null)
                    ->filter()
                    ->all(),
            );
        }
    }
}
