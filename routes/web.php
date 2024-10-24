<?php

use Illuminate\Support\Facades\Route; // Импорт Route для определения маршрутов
use App\Http\Controllers\ClientController; // Импорт ClientController для обработки запросов, связанных с клиентами

// Определяем ресурсный маршрут для управления клиентами
// Это автоматически создаст маршруты для методов index, create, store, show, edit, update и destroy контроллера ClientController
Route::resource('clients', ClientController::class);

// Определяем маршрут для главной страницы приложения
Route::get('/', function () {
    return view('welcome'); // Возвращаем представление 'welcome' для главной страницы
});
