<?php

use Illuminate\Database\Migrations\Migration; // Импорт Migration для создания миграции
use Illuminate\Database\Schema\Blueprint; // Импорт Blueprint для определения структуры таблицы
use Illuminate\Support\Facades\Schema; // Импорт Schema для работы с базой данных

class CreateUsersTable extends Migration // Класс миграции для создания таблицы пользователей
{
    public function up()
    {
        // Создаем таблицу 'users'
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Создает поле 'id' с автоинкрементом
            $table->string('name'); // Создает поле 'name' для имени пользователя
            $table->string('email')->unique(); // Создает поле 'email' с уникальным ограничением
            $table->string('password'); // Создает поле 'password' для хранения пароля
            $table->timestamps(); // Создает поля 'created_at' и 'updated_at'
        });
    }

    public function down() // Метод для отмены миграции
    {
        Schema::dropIfExists('users'); // Удаляет таблицу 'users', если она существует
    }
}
