<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Driver;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * @var array<int, array<string, string>>
     */
    private const DRIVERS = [
        [
            'license_plate' => 'А001АА777',
            'full_name' => 'Иванов Михаил Сергеевич',
            'phone' => '+7 911 123-45-67',
        ],
        [
            'license_plate' => 'В002ВВ777',
            'full_name' => 'Петрова Елена Владимировна',
            'phone' => '+7 912 234-56-78',
        ],
        [
            'license_plate' => 'Е003ЕЕ777',
            'full_name' => 'Сидоров Дмитрий Александрович',
            'phone' => '+7 913 345-67-89',
        ],
        [
            'license_plate' => 'К004КК777',
            'full_name' => 'Козлова Анна Игоревна',
            'phone' => '+7 914 456-78-90',
        ],
    ];

    public function run(): void
    {
        $cars = Car::query()
            ->pluck('id', 'license_plate');

        foreach (self::DRIVERS as $driverData) {
            $carId = $cars[$driverData['license_plate']] ?? null;

            if ($carId === null) {
                continue;
            }

            Driver::query()
                ->updateOrCreate(
                    ['car_id' => $carId],
                    [
                        'full_name' => $driverData['full_name'],
                        'phone' => $driverData['phone'],
                    ],
                );
        }
    }
}
