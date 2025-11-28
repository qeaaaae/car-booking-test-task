<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CarModel;
use App\Models\ComfortCategory;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * @var array<int, array{name: string, category: string}>
     */
    private const MODELS = [
        ['name' => 'Cadillac Escalade', 'category' => 'Класс A'],
        ['name' => 'Tesla Model 3', 'category' => 'Класс B'],
        ['name' => 'Toyota Camry', 'category' => 'Класс C'],
        ['name' => 'Ford Escape', 'category' => 'Класс D'],
    ];

    public function run(): void
    {
        $categories = ComfortCategory::query()
            ->pluck('id', 'name');

        foreach (self::MODELS as $modelData) {
            $categoryId = $categories[$modelData['category']] ?? null;

            if ($categoryId === null) {
                continue;
            }

            CarModel::query()
                ->updateOrCreate(
                    ['name' => $modelData['name']],
                    [
                        'name' => $modelData['name'],
                        'comfort_category_id' => $categoryId,
                    ],
                );
        }
    }
}
