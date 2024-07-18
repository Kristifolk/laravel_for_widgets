@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    {{-- Таблица Клиент START --}}
                    <h3>Результат поиска</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            {{--                            <th scope="col">ФИО</th>--}}
                            <th>#</th>
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
                        <tr>
                            <th>1</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Отчество</th>
                            <th>Город</th>
                            <th>Почта</th>
                            <th>Телефон</th>
                            <th>
                                <a class="btn btn-primary me-md-2" href="{{ route('client.show', 1) }}">Просмотреть</a>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                    {{-- Таблица Клиент END --}}
            </div>
        </div>
    </div>
</div>
@endsection
