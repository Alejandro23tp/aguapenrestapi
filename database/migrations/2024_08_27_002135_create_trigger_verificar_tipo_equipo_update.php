<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTriggerVerificarTipoEquipoUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER verificar_tipo_equipo_update
            BEFORE UPDATE ON equipos
            FOR EACH ROW
            BEGIN
                IF NEW.precio >= 100 THEN
                    SET NEW.es_periferico = FALSE; -- Es un equipo principal
                ELSE
                    SET NEW.es_periferico = TRUE;  -- Es un periférico
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS verificar_tipo_equipo_update');
    }
}
