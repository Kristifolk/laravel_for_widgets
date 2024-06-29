@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">

                    {{-- Таблица Клиент START --}}
                    <h3>Клиент</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            {{--                            <th>ФИО</th>--}}
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Отчество</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Отчество</th>
                        </tr>
                        </tbody>

                    </table>
                    {{-- Таблица Клиент END --}}
            </div>
                <div class="card-body">
                    {{-- Таблица Питомцы START --}}
                    <h3>Питомец клиента</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            {{--                            <th scope="col">ФИО</th>--}}
                            <th>#</th>
                            <th>Кличка</th>
                            <th>Вид</th>
                            <th>Порода</th>
                            <th>Окрас</th>
                            <th>Возраст</th>
                            <th>Редактировать</th>
                            <th>Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{--                                @foreach($pets as $pet)--}}
                    <tr>
                        <th>id</th>
                        <th>Кличка</th>
                        <th>Вид</th>
                        <th>Порода</th>
                        <th>Окрас</th>
                        <th>Возраст</th>
                        <th>
                            <a class="btn btn-primary me-md-2" href="{{ route('pet.edit', 1) }}">Редактировать</a>
                        </th>
                        <th>
                            <form action="{{ route('pet.destroy', 1) }}" method="POST" onsubmit="return confirm('Вы действительно хотите удалить этого питомца?');">
                                @csrf
                                @method('DELETE')
                                <button  type="submit" class="btn btn-primary me-md-2">Удалить</button>
                            </form>
                        </th>
                    </tr>
                    {{--                                @endforeach--}}
                    </tbody>

                    </table>
                    {{-- Таблица Питомцы END --}}
                </div>

        </div>
    </div>
</div>
@endsection
