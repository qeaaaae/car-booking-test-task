<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class AvailableCarsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'car_model_id' => ['nullable', 'integer', 'exists:car_models,id'],
            'comfort_category_id' => ['nullable', 'integer', 'exists:comfort_categories,id'],
        ];
    }

    public function startTime(): Carbon
    {
        /** @var string $value */
        $value = $this->validated('start_time');

        return Carbon::parse($value);
    }

    public function endTime(): Carbon
    {
        /** @var string $value */
        $value = $this->validated('end_time');

        return Carbon::parse($value);
    }
}
