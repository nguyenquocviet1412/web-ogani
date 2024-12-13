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
        Schema::create('userban', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('Role_id');
            $table->string('note');
            $table->enum('active',['sathai','khoataikhoan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userban');
    }
};
