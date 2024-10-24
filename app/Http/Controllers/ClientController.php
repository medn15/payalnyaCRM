<?php

namespace App\Http\Controllers;

use App\Models\Client; // Импортируем модель Client для работы с клиентами
use Illuminate\Http\Request; // Импортируем класс Request для обработки HTTP-запросов
use App\Services\WeatherService; // Импорт сервиса для работы с API OpenWeather
use App\Jobs\SendClientNotification;
use App\Notifications\ClientCreated;

class ClientController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService; // Внедрение зависимости WeatherService
    }

    // Метод для отображения списка клиентов
    public function index(Request $request)
    {
        $query = Client::query(); // Начинаем запрос на получение клиентов

        // Проверяем, есть ли в запросе параметры фильтрации
        if ($request->has('name') || $request->has('status')) {
            // Фильтрация по имени
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->input('name') . '%');
            }

            // Фильтрация по статусу
            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }
        }

        $clients = $query->paginate(5); // Получаем список клиентов с пагинацией
        $clientWeather = []; // Инициализируем массив для хранения информации о погоде

        foreach ($clients as $client) {
            // Получаем погоду для каждого клиента
            $temperature = $this->weatherService->getWeather($client->city);

            if ($temperature !== null) {
                $clientWeather[] = [
                    'name' => $client->name,
                    'city' => $client->city,
                    'temperature' => $temperature, // Температура
                ];
            }
        }

        return view('clients.index', compact('clients', 'clientWeather')); // Возвращаем представление с данными клиентов и погодой
    }


    // Метод для отображения формы создания клиента
    public function create()
    {
        return view('clients.create'); // Возвращаем представление для создания клиента
    }

    // Метод для сохранения нового клиента в базе данных
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:clients',
            'phone' => 'required|string|max:15',
            'status' => 'required|boolean',
            'city' => 'required|string|max:255',
        ]);

        // Создаем клиента
        $client = Client::create($validatedData);

        // Отправляем уведомление на почту клиента
        $client->notify(new ClientCreated($client));

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }




    // Метод для отображения формы редактирования клиента
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client')); // Возвращаем представление для редактирования клиента
    }

    // Метод для обновления информации о клиенте
    public function update(Request $request, Client $client)
    {
        // Валидация входных данных
        $request->validate([
            'name' => 'required|string|max:255', // Имя обязательно, строка, максимальная длина 255
            'email' => 'required|email|unique:clients,email,' . $client->id, // Электронная почта обязательна, уникальна с учетом текущего клиента
            'phone' => 'required|string|max:15', // Телефон обязателен, строка, максимальная длина 15
            'registered_at' => 'required|date', // Дата регистрации обязательна, должна быть датой
            'status' => 'required|boolean', // Статус должен быть булевым значением
            'city' => 'required', // Город обязателен
        ]);

        $client->update($request->all()); // Обновляем данные клиента

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.'); // Перенаправляем на индекс с сообщением об успехе
    }

    // Метод для удаления клиента
    public function destroy(Client $client)
    {
        $client->delete(); // Удаляем клиента

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.'); // Перенаправляем на индекс с сообщением об успехе
    }
}
