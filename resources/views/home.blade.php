@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
{{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                        <div>Добавить клиента</div>
{{--                        ссылка или кнопка--}}
                    <h3>Клиенты ветменеджера (лимит 50)</h3>
                    <table class="table table-hover">
                        <thead>
                            <th scope="col">#</th>
{{--                            <th scope="col">ФИО</th>--}}
                            <th scope="col">Имя</th>
                            <th scope="col">Фамилия</th>
                            <th scope="col">Отчество</th>
                            <th scope="col">Город</th>
                            <th scope="col">Питомцы</th>
                            <th class="col-1">Просмотреть</th>
                            <th class="col-1">Редактировать</th>
                            <th class="col-1">Удалить</th>

                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
