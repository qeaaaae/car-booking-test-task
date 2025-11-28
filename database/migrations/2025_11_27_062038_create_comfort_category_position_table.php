<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comfort_category_position', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('position_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('comfort_category_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['position_id', 'comfort_category_id'], 'position_category_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comfort_category_position');
    }
};
