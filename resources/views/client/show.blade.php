@extends('layouts.app')

@section('content')
    @if(session('message'))
        <div class="alert alert-success">
            {{session('message')}}
        </div>
        <script>
            setTimeout(() =>{
                const flashMessage = document.querySelector(".alert");
                flashMessage.remove();
            }, 1000);
        </script>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">

                    <div class="card-body">
                        {{-- Таблица Клиент START --}}
                        <h3>Клиент ветменеджера</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Отчество</th>
                                <th>Город</th>
                                <th>Почта</th>
                                <th>Телефон</th>
                                <th>Редактировать</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>{{ $client['id'] }}</th>
                                <th>{{ $client['first_name'] }}</th>
                                <th>{{ $client['last_name'] }}</th>
                                <th>{{ $client['middle_name'] }}</th>
                                <th>{{ $client['city_data']['title'] }}</th>
                                <th>{{ $client['email'] }}</th>
                                <th>{{ $client['home_phone'] }}</th>
                                <th>
                                    <a class="btn btn-primary me-md-2" href="{{ route('client.edit', $client['id']) }}">Редактировать</a>
                                </th>
                                <th>
                                    <form action="{{ route('client.destroy', $client['id']) }}" method="POST"
                                          onsubmit="return confirm('Вы действительно хотите удалить этого клиента со всеми питомцами?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary me-md-2">Удалить</button>
                                    </form>
                                </th>
                            </tr>
                            </tbody>

                        </table>
                        {{-- Таблица Клиент END --}}
                    </div>
                    <div class="card-body">
                        {{-- Таблица Питомцы START --}}
                        <h3>Питомцы клиента</h3>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary me-md-2" href="{{ route('pet.create', $client['id']) }}">Добавить
                                питомца</a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Кличка</th>
                                <th>Вид</th>
                                <th>Порода</th>
                                <th>Пол</th>
                                <th>Просмотреть</th>
                                <th>Редактировать</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pets as $pet)
                                <tr>
                                    <th>{{ $pet['id'] }}</th>
                                    <th>{{ $pet['alias'] }}</th>
                                    <th>{{ $pet['type']['title'] }}</th>
                                    <th>{{ $pet['breed']['title'] }}</th>
                                    <th>{{ $pet['sex'] }}</th>
                                    <th>
                                        <a class="btn btn-primary me-md-2"
                                           href="{{ route('pet.show', $pet['id']) }}">Просмотреть</a>
                                    </th>
                                    <th>
                                        <a class="btn btn-primary me-md-2" href="{{ route('pet.edit', $pet['id']) }}">Редактировать</a>
                                    </th>
                                    <th>
                                        <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST"
                                              onsubmit="return confirm('Вы действительно хотите удалить этого питомца?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary me-md-2">Удалить</button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        {{-- Таблица Питомцы END --}}
                    </div>

                </div>
            </div>
        </div>
@endsection
