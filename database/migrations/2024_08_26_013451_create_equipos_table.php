<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->boolean('es_periferico')->nullable();
            $table->string('Mac')->nullable();
            $table->string('marca');
            $table->string('modelo');
            $table->string('serie');
            $table->date('año_adquisicion');
            $table->decimal('precio', 8, 2);
            $table->string('codigo_contable')->nullable();
            $table->string('direccion_ip')->nullable();
            $table->string('dominio')->nullable();
            $table->string('estado');
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};