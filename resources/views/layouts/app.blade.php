<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- адаптивная верстка -->
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Токен CSRF для защиты форм -->
    <title>@yield('title', 'CRM')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Подключение стилей -->
    </head>
<body>
    <nav>
        <!-- навигация -->
    </nav>

    <div class="content">
        @yield('content') <!-- Этот блок будет заменен содержимым дочерних шаблонов -->
    </div>

    <footer>
        <!-- футер -->
    </footer>

   <!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>
