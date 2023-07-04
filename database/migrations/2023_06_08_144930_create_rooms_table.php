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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('room_number')->comment('部屋番号');
            $table->string('room_name')->nullable()->comment('部屋名');
            $table->string('column_name')->nullable()->comment('カラム名');
            $table->integer('price')->comment('価格');
            $table->integer('k-flag')->default(0)->comment('管理フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
