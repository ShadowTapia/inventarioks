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
        Schema::create('devices', function (Blueprint $table) {
            $table->comment('Tabla de dispositivos');
            $table->id();
            $table->string('numserie')->unique();
            $table->date('fechacompra')->nullable();
            $table->longText('comentarios', 100)->nullable();
            $table->enum('estado', [1, 2])->default(1); //1 Activo 2 Inactivo

            $table->foreignId('products_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('department_id')
                ->constrained()
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
        Schema::dropIfExists('devices');
    }
};
