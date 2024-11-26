<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciasMaliciosasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('denuncias_maliciosas', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT
            $table->foreignId('denuncia_id')->constrained()->onDelete('cascade'); // FK hacia la tabla denuncias
            $table->text('razon'); // TEXTO que describe la razón de la denuncia maliciosa
            $table->decimal('sancion', 10, 2); // DECIMAL para la sanción
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias_maliciosas');
    }
};
