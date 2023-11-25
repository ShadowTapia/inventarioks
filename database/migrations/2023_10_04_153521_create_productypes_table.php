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
        Schema::create('productypes', function (Blueprint $table) {
            $table->comment('Tipos de productos, aquí se establecen si son Impresoras, pantallas, pc, etc.');
            $table->id();
            $table->string('name', 50);
            $table->longText('description', 80)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productypes');
    }
};
