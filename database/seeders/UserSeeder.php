<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * @var array<int, array<string, string>>
     */
    private const USERS = [
        [
            'name' => 'Ольга Беннет',
            'email' => 'executive@example.com',
            'password' => 'password',
            'position' => 'Генеральный директор',
        ],
        [
            'name' => 'Лев Тернер',
            'email' => 'director@example.com',
            'password' => 'password',
            'position' => 'Директор по операционной деятельности',
        ],
        [
            'name' => 'Эмма Коллинз',
            'email' => 'manager@example.com',
            'password' => 'password',
            'position' => 'Менеджер по продажам',
        ],
    ];

    public function run(): void
    {
        $positions = Position::query()
            ->pluck('id', 'name');

        foreach (self::USERS as $userData) {
            $positionId = $positions[$userData['position']] ?? null;

            if ($positionId === null) {
                continue;
            }

            User::query()
                ->updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => Hash::make($userData['password']),
                        'position_id' => $positionId,
                    ],
                );
        }
    }
}
