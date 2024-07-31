@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    {{-- Таблица Клиент START --}}
                    <h2 class="text-primary">{{ $searchInfoMessage }}</h2>
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
                            <th>Просмотреть</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($foundClients as $client)
                            <tr>
{{--TODO корректная нумерация # клиентов --}}
                            <th>{{ $client['id'] }}</th>
                            <th>{{ $client['first_name'] }}</th>
                            <th>{{ $client['last_name'] }}</th>
                            <th>{{ $client['middle_name'] }}</th>
                            <th>{{ $client['city'] }}</th>
                            <th>{{ $client['email'] }}</th>
                            <th>{{ $client['home_phone'] }}</th>
                            <th>
                                <a class="btn btn-primary me-md-2" href="{{ route('client.show', $client['id'] ) }}">Просмотреть</a>
                            </th>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{-- Таблица Клиент END --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
