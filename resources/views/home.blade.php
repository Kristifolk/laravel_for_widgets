@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div style="padding-bottom: 10px">
                            <form class="d-flex" action="{{ route('search') }}" method="GET">
                                @csrf
                                @method('GET')
                                <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск">
                                <button class="btn btn-outline-primary" type="submit">Поиск клиента</button>
                            </form>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary me-md-2" href="{{ route('client.create') }}">Добавить клиента</a>
                        </div>
                        {{-- Таблица START --}}
                        <h3>Клиенты ветменеджера (лимит 50)</h3>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                {{--                            <th scope="col">ФИО</th>--}}
                                <th scope="col">Имя</th>
                                <th scope="col">Фамилия</th>
                                <th scope="col">Отчество</th>
                                <th scope="col">Питомцы</th>
                                <th class="col-1">Просмотреть</th>
                                <th class="col-1">Редактировать</th>
                                <th class="col-1">Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--                                @foreach($clients as $client)--}}
                            <tr>
                                <th>id или порядковый номер от 1 до 50</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Отчество</th>
                                <th>Питомцы</th>
                                <th>
                                    <a class="btn btn-primary me-md-2"
                                       href="{{ route('client.show', 1) }}">Просмотреть</a>
                                </th>
                                <th>
                                    <a class="btn btn-primary me-md-2" href="{{ route('client.edit', 1) }}">Редактировать</a>
                                </th>
                                <th>
                                    <form action="{{ route('client.destroy', 1) }}" method="POST" onsubmit="return confirm('Вы действительно хотите удалить этого клиента со всеми питомцами?');">
                                        @csrf
                                        @method('DELETE')
                                        <button  type="submit" class="btn btn-primary me-md-2">Удалить</button>
                                    </form>
                                </th>
                            </tr>
                            {{--                                @endforeach--}}
                            </tbody>

                        </table>
                        {{-- Таблица END --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
