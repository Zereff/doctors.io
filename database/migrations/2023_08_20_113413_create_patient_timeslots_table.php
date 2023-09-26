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
        Schema::create('patient_timeslots', function (Blueprint $table) {
            $table->foreignId('patient_id')
                ->references('id')->on('patients')->cascadeOnDelete();
            $table->foreignId('timeslot_id')
                ->references('id')->on('timeslots')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['patient_id', 'timeslot_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_timeslots');
    }
};
