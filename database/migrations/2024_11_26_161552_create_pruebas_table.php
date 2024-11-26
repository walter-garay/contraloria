<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pruebas', function (Blueprint $table) {
            $table->bigIncrements('id'); // Clave primaria
            $table->unsignedBigInteger('denuncia_id'); // Clave foránea
            $table->string('archivo');
            $table->text('descripcion')->nullable();
            $table->timestamps(); // Campos created_at y updated_at

            // Definir la clave foránea
            $table->foreign('denuncia_id')->references('id')->on('denuncias')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pruebas');
    }
};
