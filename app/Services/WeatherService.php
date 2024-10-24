<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENWEATHER_API_KEY'); // API ключ находится в .env
    }

    public function getWeather($city)
    {
        // Используем кэширование на 60 минут
        return Cache::remember("weather_{$city}", 60 * 60, function () use ($city) {
            try {
                $response = $this->client->get('https://api.openweathermap.org/data/2.5/weather', [
                    'query' => [
                        'q' => $city,
                        'appid' => $this->apiKey,
                        'units' => 'metric',
                    ],
                ]);

                $data = json_decode($response->getBody(), true);
                if (isset($data['main']['temp'])) {
                    return $data['main']['temp']; // Возвращаем температуру
                }
            } catch (RequestException $e) {
                // Обработка ошибок, например, логирование
                \Log::error('Weather API request failed: ' . $e->getMessage());
            }

            return null; // В случае ошибки возвращаем null
        });
    }
}
