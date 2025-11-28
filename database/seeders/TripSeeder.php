<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TripSeeder extends Seeder
{
    /**
     * @var array<int, array<string, string>>
     */
    private const TRIPS = [
        [
            'license_plate' => 'А001АА777',
            'user' => 'executive@example.com',
            'start' => '+1 day 09:00',
            'end' => '+1 day 13:00',
            'purpose' => 'Встречи с инвесторами в разных районах города',
        ],
        [
            'license_plate' => 'Е003ЕЕ777',
            'user' => 'manager@example.com',
            'start' => '+0 day 08:00',
            'end' => '+0 day 12:00',
            'purpose' => 'Инспекция объекта клиента',
        ],
    ];

    public function run(): void
    {
        $cars = Car::query()
            ->pluck('id', 'license_plate');
        $users = User::query()
            ->pluck('id', 'email');

        foreach (self::TRIPS as $tripData) {
            $carId = $cars[$tripData['license_plate']] ?? null;
            $userId = $users[$tripData['user']] ?? null;

            if ($carId === null || $userId === null) {
                continue;
            }

            Trip::query()
                ->updateOrCreate(
                    [
                        'car_id' => $carId,
                        'user_id' => $userId,
                        'start_time' => Carbon::parse($tripData['start'], config('app.timezone'))->second(0),
                    ],
                    [
                        'end_time' => Carbon::parse($tripData['end'], config('app.timezone'))->second(0),
                        'purpose' => $tripData['purpose'],
                    ],
                );
        }
    }
}
