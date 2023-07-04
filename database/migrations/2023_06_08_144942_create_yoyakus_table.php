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
        Schema::create('yoyakus', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('日付');
            $table->integer('room1')->default(0)->comment('部屋1');
            $table->integer('room2')->default(0)->comment('部屋2');
            $table->integer('room3')->default(0)->comment('部屋3');
            $table->integer('room4')->default(0)->comment('部屋4');
            $table->integer('room5')->default(0)->comment('部屋5');
            $table->integer('room6')->default(0)->comment('部屋6');
            $table->integer('room7')->default(0)->comment('部屋7');
            $table->integer('room8')->default(0)->comment('部屋8');
            $table->integer('room9')->default(0)->comment('部屋9');
            $table->integer('room10')->default(0)->comment('部屋10');
            $table->integer('k_flag')->default(0)->comment('管理フラグ');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yoyakus');
    }
};
