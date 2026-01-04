<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('montaje_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);

            $table->foreignId('tipo_servicio_id')
                ->constrained('tipo_servicios')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->longText('descripcion')->nullable(); // rich text (HTML)
            $table->json('fotos')->nullable(); // varias fotos

            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('montaje_servicios');
    }
};
