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
        Schema::create('dashboard_widgets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Define el campo user_id
            $table->foreign('user_id')->references('id')->on('users') // Relación con la tabla users
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->string('name'); // Ej: "Widget 1"
            $table->integer('x')->default(0);      // Posición X
            $table->integer('y')->default(0);      // Posición Y
            $table->integer('width')->default(4);  // Ancho
            $table->integer('height')->default(2); // Alto
            $table->unsignedBigInteger('status'); // Define el campo status
            $table->foreign('status')->references('id')->on('statuses') // Relación con la tabla statuses
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
        Schema::dropIfExists('dashboard_widgets');
    }
};
