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
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('specialty_id')->nullable();
            $table->tinyInteger('day')->comment('0: Sunday, 1: Monday, 2: Tuesday, 3: Wednesday, 4: Thursday, 5: Friday, 6: Saturday');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('specialty_id')->references('id')->on('specialties')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availabilities');
    }
};
