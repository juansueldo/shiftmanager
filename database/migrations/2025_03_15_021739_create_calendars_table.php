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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->dateTime('date');
            $table->string('google_event_id')->nullable();
            $table->unsignedBigInteger('patientid');
            $table->foreign('patientid')->references('id')->on('patients') 
            ->onUpdate('cascade')
            ->onDelete('restrict');

            $table->unsignedBigInteger('status')->default(1);
            $table->foreign('status')->references('id')->on('statuses')
            ->onUpdate('cascade')
            ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
