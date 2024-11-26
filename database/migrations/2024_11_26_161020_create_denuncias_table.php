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
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id(); // id: BIGINT [PK]
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user_id: BIGINT [FK]

            $table->string('entidad'); // entidad: VARCHAR
            $table->string('lugar'); // lugar: VARCHAR
            $table->text('descripcion'); // descripcion: TEXT
            $table->date('fecha_probable'); // fecha_probable: DATE
            $table->integer('prioridad')->nullable(); // prioridad: INT [NULLABLE]
            $table->string('tipo_de_hecho')->nullable(); // tipo_de_hecho: VARCHAR [NULLABLE]
            $table->decimal('monto_economico', 15, 2)->nullable(); // monto_economico: DECIMAL [NULLABLE]
            $table->text('otros_colaboradores'); // otros_colaboradores: TEXT
            $table->boolean('sigue_ocurriendo')->nullable(); // sigue_ocurriendo: BOOLEAN [NULLABLE]
            $table->enum('estado', ['En proceso', 'Admitido', 'No admitido', 'Derivado a OCI'])->default('En proceso'); // estado: ENUM

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
