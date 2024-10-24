@extends('layouts.app') <!-- Расширяем базовый шаблон приложения -->

@section('content')
<div class="container">
    <h1>Add Client</h1> <!-- Заголовок страницы добавления клиента -->

    <!-- Форма для добавления нового клиента -->
    <form method="POST" class="form-group" action="{{ route('clients.store') }}">
        @csrf <!-- Защита от CSRF-атак -->
        <input type="text" name="name" placeholder="Name" required> <!-- Поле для ввода имени клиента -->
        <input type="email" name="email" placeholder="Email" required> <!-- Поле для ввода email клиента -->
        <input type="text" id="phone" name="phone" placeholder="Phone" required> <!-- Поле для ввода номера телефона клиента -->

        <select name="status" required> <!-- Выбор статуса клиента -->
            <option value="" disabled selected>Select Status</option>
            <option value="1">Active</option> <!-- Опция для активного клиента -->
            <option value="0">Inactive</option> <!-- Опция для неактивного клиента -->
        </select>

        <div class="form-group">
            <label for="city">City</label>
            <select name="city" id="city" class="form-control" required>
                <option value="" disabled selected>Select a City</option>
                <option value="Chicago">Chicago</option>
                <option value="Memphis">Memphis</option>
                <option value="Riverside">Riverside</option>
                <option value="Phoenix">Phoenix</option>
            </select>
        </div>

        <button type="submit">Add Client</button> <!-- Кнопка для отправки формы -->
    </form>
</div>

<script>
    // Функция валидации формы
    function validateForm() {
        const phoneInput = document.getElementById('phone'); // Получаем элемент ввода номера телефона
        const phonePattern = /^\(\d{3}\) \d{3}-\d{4}$/; // Маска для номера телефона
        const phoneValue = phoneInput.value.replace(/\D/g, ''); // Удаляем все, кроме цифр

        // Проверка длины номера телефона
        if (phoneValue.length !== 10) {
            alert('Phone number must be 10 digits long.');
            return false; // Не отправляем форму
        }

        // Проверка соответствия маске
        if (!phonePattern.test(phoneInput.value)) {
            alert('Phone number must be in the format (123) 456-7890.');
            return false; // Не отправляем форму
        }

        return true; // Отправляем форму
    }

    // Простая маска для ввода номера телефона
    document.getElementById('phone').addEventListener('input', function (e) {
        let value = e.target.value
            .replace(/\D/g, '') // Удаляем все, кроме цифр
            .slice(0, 10); // Ограничиваем длину до 10 цифр

        // Форматируем номер в (123) 456-7890
        if (value.length >= 6) {
            value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6)}`;
        } else if (value.length >= 3) {
            value = `(${value.slice(0, 3)}) ${value.slice(3)}`;
        } else if (value.length > 0) {
            value = `(${value}`;
        }
        e.target.value = value; // Обновляем значение поля ввода
    });
</script>

@endsection
