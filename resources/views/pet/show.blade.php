@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">

                    {{-- Таблица Клиент START --}}
                    <h3 class="text-primary">Клиент</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Отчество</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>{{ $pet['owner']['first_name'] }}</th>
                            <th>{{ $pet['owner']['last_name'] }}</th>
                            <th>{{ $pet['owner']['middle_name'] }}</th>
                        </tr>
                        </tbody>
                    </table>
                    {{-- Таблица Клиент END --}}
                </div>
                <div class="card-body">
                    {{-- Таблица Питомцы START --}}
                    <h3 class="text-primary">Питомец клиента</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Кличка</th>
                            <th>Вид</th>
                            <th>Порода</th>
                            <th>Пол</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>{{ $pet['id'] }}</th>
                            <th>{{ $pet['alias'] }}</th>
                            <th>{{ $pet['type']['title'] }}</th>
                            <th>{{ $pet['breed']['title'] }}</th>
                            <th>
                                @switch($pet['sex'])
                                    @case('unknown')
                                        Не известен
                                        @break
                                    @case('male')
                                        Самец
                                        @break
                                    @case('female')
                                        Самка
                                        @break
                                    @default
                                        Не указано
                                @endswitch
                            </th>
                            <th>
                                <a class="btn btn-primary me-md-2" href="{{ route('pet.edit', $pet['id']) }}">Редактировать</a>
                            </th>
                            <th>
                                <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST" onsubmit="return confirm('Вы действительно хотите удалить этого питомца?');">
                                    @csrf
                                    @method('DELETE')
                                    <button  type="submit" class="btn btn-primary me-md-2">Удалить</button>
                                </form>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    {{-- Таблица Питомцы END --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
