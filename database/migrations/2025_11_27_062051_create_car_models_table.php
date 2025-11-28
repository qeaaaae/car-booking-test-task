<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_models', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('comfort_category_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['comfort_category_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
