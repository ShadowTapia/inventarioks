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
        Schema::create('products', function (Blueprint $table) {
            $table->comment('Tabla de Productos');
            $table->id();
            $table->string('name', 50);
            $table->longText('description', 100)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('imageable_id')->nullable();
            $table->string('imageable_type')->nullable();

            $table->foreignId('users_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('productype_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');


            $table->foreignId('supplier_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('company_id')
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
        Schema::dropIfExists('products');
    }
};
