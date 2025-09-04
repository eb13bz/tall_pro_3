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
        Schema::create('clientes', function (Blueprint $table) {
           $table->id();
        $table->string('nombre_completo');
        $table->string('cedula_nit')->unique()->nullable();
        $table->string('direccion')->nullable();
        $table->string('telefono')->nullable();
        $table->string('correo_electronico')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
