<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @mixin \App\Models\Car
 */
#[OA\Schema(
    schema: 'CarResource',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'license_plate', type: 'string', example: 'USA-001'),
        new OA\Property(property: 'vin', type: 'string', nullable: true, example: '1GYS4DKJ0MR123456'),
        new OA\Property(property: 'manufactured_year', type: 'integer', nullable: true, example: 2023),
        new OA\Property(property: 'color', type: 'string', nullable: true, example: 'Black'),
        new OA\Property(
            property: 'model',
            type: 'object',
            nullable: true,
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 10),
                new OA\Property(property: 'name', type: 'string', example: 'Cadillac Escalade'),
            ],
        ),
        new OA\Property(
            property: 'comfort_category',
            type: 'object',
            nullable: true,
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 99),
                new OA\Property(property: 'name', type: 'string', example: 'Class A'),
                new OA\Property(property: 'level', type: 'integer', example: 1),
            ],
        ),
        new OA\Property(
            property: 'driver',
            type: 'object',
            nullable: true,
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 5),
                new OA\Property(property: 'full_name', type: 'string', example: 'Michael Carter'),
                new OA\Property(property: 'phone', type: 'string', nullable: true, example: '+1 206 555 0101'),
            ],
        ),
    ],
)]
class CarResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $carModel = $this->carModel;
        $comfortCategory = $carModel?->comfortCategory;
        $driver = $this->driver;

        return [
            'id' => $this->id,
            'license_plate' => $this->license_plate,
            'vin' => $this->vin,
            'manufactured_year' => $this->manufactured_year,
            'color' => $this->color,
            'model' => $carModel ? [
                'id' => $carModel->id,
                'name' => $carModel->name,
            ] : null,
            'comfort_category' => $comfortCategory ? [
                'id' => $comfortCategory->id,
                'name' => $comfortCategory->name,
                'level' => $comfortCategory->level,
            ] : null,
            'driver' => $driver ? [
                'id' => $driver->id,
                'full_name' => $driver->full_name,
                'phone' => $driver->phone,
            ] : null,
        ];
    }
}
