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
        Schema::create('doctor_specialty', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id'); // Relación con la tabla doctors
            $table->unsignedBigInteger('specialty_id'); // Relación con la tabla specialties
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

            // Índice único para evitar duplicados
            $table->unique(['doctor_id', 'specialty_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_specialty');
    }
};
