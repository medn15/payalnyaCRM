@extends('layouts.app') <!-- Расширяем базовый шаблон приложения -->

@section('content')
<div class="container">
    <h1>Clients</h1> <!-- Заголовок страницы -->

    <!-- Форма для фильтрации клиентов по имени и статусу -->
    <div class="form-group">
    <form method="GET" id="search-client" action="{{ route('clients.index') }}">
        <input type="text" name="name" placeholder="Search by name" value="{{ request('name') }}">
        <select name="status">
            <option value="">All</option> <!-- Опция для отображения всех клиентов -->
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option> <!-- Опция для активных клиентов -->
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option> <!-- Опция для неактивных клиентов -->
        </select>
        <button type="submit">Filter</button> <!-- Кнопка для применения фильтров -->
    </form>
    </div>

    <div class="mb-3">
        <!-- Кнопка для добавления нового клиента, ведет на страницу создания -->
        <a href="{{ route('clients.create') }}" class="btn btn-success">Add Client</a>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registered At</th>
                    <th>Status</th>
                    <th>City</th> <!-- Новый заголовок для города -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client) <!-- Перебираем всех клиентов -->
                <tr>
                    <td>{{ $client->name }}</td> <!-- Имя клиента -->
                    <td>{{ $client->email }}</td> <!-- Email клиента -->
                    <td>{{ $client->phone }}</td> <!-- Номер телефона клиента -->
                    <td>{{ $client->registered_at }}</td> <!-- Дата регистрации клиента -->
                    <td>{{ $client->status ? 'Active' : 'Inactive' }}</td> <!-- Статус клиента: активный или неактивный -->
                    <td>{{ $client->city }} {{ $clientWeather[$loop->index]['temperature'] ?? 'N/A' }}°C</td> <!-- Город и температура -->
                    <td class="actions">
                        <div style="display: flex; justify-content: space-between;">
                            <!-- Кнопка редактирования клиента, ведет на страницу редактирования -->
                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Edit</a>
                            <!-- Форма для удаления клиента -->
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline;">
                                @csrf <!-- Защита от CSRF-атак -->
                                @method('DELETE') <!-- Указываем, что метод формы - DELETE -->
                                <button type="submit" class="btn btn-danger">Delete</button> <!-- Кнопка для удаления клиента -->
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- пагинация списка -->
        <div class="d-flex justify-content-center mt-3">
            {{ $clients->links() }} <!-- Выводим ссылки для навигации по страницам -->
        </div>

    </div>
</div>
@endsection
