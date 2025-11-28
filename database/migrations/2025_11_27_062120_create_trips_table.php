<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('car_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->text('purpose')->nullable();
            $table->timestamps();

            $table->index(['car_id', 'start_time', 'end_time'], 'trips_car_time_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
