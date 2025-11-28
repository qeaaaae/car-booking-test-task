<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ComfortCategorySeeder::class,
            PositionSeeder::class,
            CarModelSeeder::class,
            CarSeeder::class,
            DriverSeeder::class,
            UserSeeder::class,
            TripSeeder::class,
        ]);
    }
}
