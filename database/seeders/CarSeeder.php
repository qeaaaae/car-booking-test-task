<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * @var array<int, array<string, mixed>>
     */
    private const CARS = [
        [
            'model' => 'Cadillac Escalade',
            'license_plate' => 'А001АА777',
            'vin' => 'XTA210990Y1234561',
            'manufactured_year' => 2023,
            'color' => 'Черный',
        ],
        [
            'model' => 'Tesla Model 3',
            'license_plate' => 'В002ВВ777',
            'vin' => '5YJ3E1EA7MF123457',
            'manufactured_year' => 2022,
            'color' => 'Жемчужно-белый',
        ],
        [
            'model' => 'Toyota Camry',
            'license_plate' => 'Е003ЕЕ777',
            'vin' => 'XTA210990Y7654322',
            'manufactured_year' => 2021,
            'color' => 'Серебристый',
        ],
        [
            'model' => 'Ford Escape',
            'license_plate' => 'К004КК777',
            'vin' => '1FMCU9H64MUB12346',
            'manufactured_year' => 2020,
            'color' => 'Синий',
        ],
    ];

    public function run(): void
    {
        $models = CarModel::query()
            ->pluck('id', 'name');

        foreach (self::CARS as $carData) {
            $modelId = $models[$carData['model']] ?? null;

            if ($modelId === null) {
                continue;
            }

            Car::query()
                ->updateOrCreate(
                    ['license_plate' => $carData['license_plate']],
                    [
                        'car_model_id' => $modelId,
                        'vin' => $carData['vin'],
                        'manufactured_year' => $carData['manufactured_year'],
                        'color' => $carData['color'],
                        'notes' => null,
                    ],
                );
        }
    }
}
