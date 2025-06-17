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
        Schema::create('setups', function (Blueprint $table)
        {
            $table->id();
            $table->uuid();
            $table->integer('user_id');
            $table->integer('simulator_id');
            $table->integer('track_id');
            $table->integer('car_id');
            $table->unsignedBigInteger('lap_time_ms');
            $table->timestamp('lap_time_recorded_at');
            $table->enum('setup_type', ['Qualifying', 'Wet', 'Race']);
            $table->json('setup_data');
            $table->boolean('is_public')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setups');
    }
};
