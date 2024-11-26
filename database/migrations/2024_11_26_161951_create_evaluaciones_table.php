<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluacionesTable extends Migration
{
    public function up()
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->bigIncrements('id'); // Clave primaria
            $table->unsignedBigInteger('denuncia_id'); // Clave foránea a Denuncias
            $table->unsignedBigInteger('auditor_id');  // Clave foránea a Auditores
            $table->text('observaciones');
            $table->enum('resultado', ['Desestimado', 'Pasa a Control']);
            $table->timestamp('fecha_evaluacion');
            $table->timestamps(); // Campos created_at y updated_at

            // Definir las claves foráneas
            $table->foreign('denuncia_id')->references('id')->on('denuncias')->onDelete('cascade');
            $table->foreign('auditor_id')->references('id')->on('auditores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('evaluaciones');
    }
}
