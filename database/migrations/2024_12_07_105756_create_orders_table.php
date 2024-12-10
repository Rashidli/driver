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

            $table->string('name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->timestamp('time');
            $table->decimal('price')->nullable();
            $table->enum('last_status',['accepted','reached','picked','completed','cancelled'])->default('accepted');

            $table->unsignedBigInteger('driver_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id')->nullable();

            $table->string('car_mark')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_plate')->nullable();
            $table->string('order_tariff')->nullable();
            $table->string('payment_tariff')->nullable();
            $table->text('comment')->nullable();

            $table->boolean('is_performer')->default(false);
            $table->unsignedBigInteger('is_performer_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
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
