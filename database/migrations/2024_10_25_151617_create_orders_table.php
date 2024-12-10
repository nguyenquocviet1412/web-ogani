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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('User_id');
            $table->string('fullname',50)->nullable();
            $table->string('email',100)->nullable();
            $table->string('Phone_number',20)->nullable();
            $table->string('note',200)->nullable();
            $table->dateTime('Order_date')->nullable();
            $table->enum('status',['pending','processing','shipped','delivered','cancelled'])->nullable();
            $table->float('Total_money')->nullable();
            $table->string('Shipping_address',250)->nullable();
            $table->integer('Payment_id')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
