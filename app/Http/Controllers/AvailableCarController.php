<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\AvailableCarsRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class AvailableCarController extends Controller
{
    #[OA\Get(
        path: '/api/available-cars',
        summary: 'Список автомобилей, доступных текущему пользователю между двумя временными метками',
        security: [['bearerAuth' => []]],
        tags: ['Автомобили'],
        parameters: [
            new OA\Parameter(name: 'start_time', in: 'query', required: true, schema: new OA\Schema(type: 'string', format: 'date-time'), description: 'Время начала периода'),
            new OA\Parameter(name: 'end_time', in: 'query', required: true, schema: new OA\Schema(type: 'string', format: 'date-time'), description: 'Время окончания периода'),
            new OA\Parameter(name: 'car_model_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'ID модели автомобиля'),
            new OA\Parameter(name: 'comfort_category_id', in: 'query', required: false, schema: new OA\Schema(type: 'integer'), description: 'ID категории комфорта'),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список доступных автомобилей',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: '#/components/schemas/CarResource'),
                ),
            ),
            new OA\Response(response: 401, description: 'Неавторизован'),
            new OA\Response(response: 422, description: 'Ошибка валидации'),
        ],
    )]
    public function __invoke(AvailableCarsRequest $request): AnonymousResourceCollection
    {
        $user = $request->user();
        $position = $user?->position;
        $allowedCategoryIds = $position?->comfortCategories()->pluck('comfort_categories.id')->all() ?? [];

        if ($allowedCategoryIds === []) {
            return CarResource::collection(collect());
        }

        $start = $request->startTime();
        $end = $request->endTime();

        $filters = $request->validated();
        $carModelId = array_key_exists('car_model_id', $filters)
            ? (int) $filters['car_model_id']
            : null;
        $comfortCategoryFilterId = array_key_exists('comfort_category_id', $filters)
            ? (int) $filters['comfort_category_id']
            : null;

        $cars = Car::query()
            ->with([
                'carModel.comfortCategory',
                'driver',
            ])
            ->whereHas('carModel.comfortCategory', function (Builder $query) use ($allowedCategoryIds): void {
                $query->whereIn('comfort_categories.id', $allowedCategoryIds);
            })
            ->when(
                value: $carModelId,
                callback: function (Builder $query, int $modelId): void {
                    $query->where('car_model_id', $modelId);
                }
            )
            ->when(
                value: $comfortCategoryFilterId,
                callback: function (Builder $query, int $categoryId): void {
                    $query->whereHas('carModel', function (Builder $modelQuery) use ($categoryId): void {
                        $modelQuery->where('comfort_category_id', $categoryId);
                    });
                }
            )
            ->whereDoesntHave('trips', function (Builder $query) use ($start, $end): void {
                $query->where(function (Builder $intervalQuery) use ($start, $end): void {
                    $intervalQuery
                        ->where('start_time', '<', $end)
                        ->where('end_time', '>', $start);
                });
            })
            ->get();

        return CarResource::collection($cars);
    }
}