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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Создаем поле user_id с INT типом
            $table->foreign('user_id')->references('id')->on('users'); // Устанавливаем внешний ключ, связанный с таблицей users
            $table->string('nickname', 20); // Псевдоним
            $table->string('full_name', 30);
            $table->date('date_birth');
            $table->text('biography', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
