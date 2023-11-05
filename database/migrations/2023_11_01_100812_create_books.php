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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('author_id');                        // Создаем поле author_id с INT типом
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');  // Устанавливаем внешний ключ, связанный с таблицей authors
            $table->string('name', 50);                                     // Название книги
            $table->text('description', 500);                               // Описание
            $table->enum('type', ['Графическое издание', 'Цифровое издание', 'Печатное издание ']);    // Тип издания
            $table->date('publish_date');                                    // дата публикации

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
