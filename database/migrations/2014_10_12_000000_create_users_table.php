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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('Fullname',50);
            $table->tinyInteger('gender')->nullable();
            $table->string('Phone_number',20)->nullable();
            $table->string('address',250)->nullable();
            $table->string('password',100);
            $table->dateTime('Created_at')->nullable();
            $table->dateTime('Updated_at')->nullable();
            $table->tinyInteger('Is_active')->nullable();
            $table->integer('Role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
