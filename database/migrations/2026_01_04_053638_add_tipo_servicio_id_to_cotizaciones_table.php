<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Cambiar tipo a BIGINT UNSIGNED
        DB::statement("ALTER TABLE cotizaciones MODIFY servicio BIGINT UNSIGNED NULL");

        // 2) Crear FK (si no existe)
        DB::statement("
            ALTER TABLE cotizaciones
            ADD CONSTRAINT fk_cotizaciones_servicio
            FOREIGN KEY (servicio) REFERENCES tipo_servicios(id)
            ON UPDATE CASCADE
            ON DELETE SET NULL
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE cotizaciones DROP FOREIGN KEY fk_cotizaciones_servicio");
        DB::statement("ALTER TABLE cotizaciones MODIFY servicio VARCHAR(150) NULL");
    }
};
