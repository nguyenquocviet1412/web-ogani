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
            $table->id('Product_id');
            $table->string('name',250)->nullable();
            $table->float('price')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('Created_by')->nullable();
            $table->dateTime('Updated_by')->nullable();
            $table->integer('Categor_id');
            $table->integer('Origin_id');
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
