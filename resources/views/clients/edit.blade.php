@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Client</h1>

    <!-- Форма для редактирования существующего клиента -->
    <form method="POST" action="{{ url('/clients', ['id' => $client->id]) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $client->name }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $client->email }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="{{ $client->phone }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="registered_at">Registered At:</label>
            <input type="date" id="registered_at" name="registered_at" value="{{ $client->registered_at }}" required class="form-control">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1" {{ $client->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $client->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label for="city">City</label>
            <select name="city" id="city" class="form-control" required>
                <option value="" disabled>Select a City</option>
                <option value="Chicago" {{ $client->city == 'Chicago' ? 'selected' : '' }}>Chicago</option>
                <option value="Memphis" {{ $client->city == 'Memphis' ? 'selected' : '' }}>Memphis</option>
                <option value="Riverside" {{ $client->city == 'Riverside' ? 'selected' : '' }}>Riverside</option>
                <option value="Phoenix" {{ $client->city == 'Phoenix' ? 'selected' : '' }}>Phoenix</option>
            </select>
        </div>

        <!-- Кнопка обновления клиента -->
        <button type="submit" class="btn btn-primary">Update Client</button>
    </form>
</div>
@endsection
