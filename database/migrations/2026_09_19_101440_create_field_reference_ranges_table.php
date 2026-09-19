<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('field_reference_ranges', function (Blueprint $table) {
            $table->id();
            $table->string('table');
            $table->string('field');
            $table->string('label');
            $table->string('unit')->nullable();
            $table->decimal('min_value', 12, 4)->nullable();
            $table->decimal('max_value', 12, 4)->nullable();
            $table->decimal('weighted_average', 12, 4)->nullable();
            $table->decimal('normal_value', 12, 4)->nullable();
            $table->decimal('warning_value', 12, 4)->nullable();
            $table->decimal('alert_value', 12, 4)->nullable();
            $table->timestamps();

            $table->unique(['table', 'field']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_reference_ranges');
    }
};
