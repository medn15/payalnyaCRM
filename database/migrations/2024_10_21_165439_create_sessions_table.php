<?php

use Illuminate\Database\Migrations\Migration; // Импорт Migration для создания миграции
use Illuminate\Database\Schema\Blueprint; // Импорт Blueprint для определения структуры таблицы
use Illuminate\Support\Facades\Schema; // Импорт Schema для работы с базой данных

return new class extends Migration // Анонимный класс, наследующий Migration для создания таблицы 'sessions'
{
    public function up(): void // Метод для применения миграции
    {
        // Создаем таблицу 'sessions'
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Создает поле 'id' как первичный ключ
            $table->foreignId('user_id')->nullable()->index(); // Создает поле 'user_id' для связи с пользователем, может быть null, индексируется
            $table->string('ip_address', 45)->nullable(); // Создает поле 'ip_address' для хранения IP-адреса пользователя, может быть null
            $table->text('user_agent')->nullable(); // Создает поле 'user_agent' для хранения информации о браузере, может быть null
            $table->longText('payload'); // Создает поле 'payload' для хранения сериализованных данных сессии
            $table->integer('last_activity')->index(); // Создает поле 'last_activity' для хранения временной метки последней активности, индексируется
        });
    }

    public function down(): void // Метод для отмены миграции
    {
        Schema::dropIfExists('sessions'); // Удаляет таблицу 'sessions', если она существует
    }
};
