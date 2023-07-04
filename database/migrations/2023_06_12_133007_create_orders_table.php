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
            $table->string('name')->comment('名前');
            $table->string('email')->comment('メールアドレス');
            $table->string('tel')->comment('電話番号');
            $table->date('date')->comment('宿泊日');
            $table->string('room_type')->comment('部屋タイプ');
            $table->integer('room_number')->comment('部屋番号');
            $table->string('yubin')->nullable()->comment('郵便番号');
            $table->string('address')->nullable()->comment('住所');
            $table->integer('price')->comment('price');
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
