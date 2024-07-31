@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('client.store') }}" method="POST"
                          onsubmit="return confirm('Проверьте правильность внесенных данных клиента');">
                        @csrf

                        <label for="basic-url" class="text-primary">Клиент Ветменеджер</label>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Имя</span>
                            <input type="text" class="form-control" placeholder="Введите имя клиента"
                                   aria-label="Имя" aria-describedby="basic-addon1" name="first_name" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Фамилия</span>
                            <input type="text" class="form-control" placeholder="Введите фамилию клиента"
                                   aria-label="Имя" aria-describedby="basic-addon1" name="last_name" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Отчество</span>
                            <input type="text" class="form-control" placeholder="Введите отчество клиента"
                                   aria-label="Имя" aria-describedby="basic-addon1" name="middle_name">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Почта</span>
                            <input type="text" class="form-control"
                                   placeholder="Введите адрес электронной почты клиента" aria-label="Имя"
                                   aria-describedby="basic-addon1" name="email">
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text">Город</span>
                            <input type="text" class="form-control" placeholder="Введите город клиента"
                                   aria-label="Город" name="city">
                            <span class="input-group-text">Телефон</span>
                            <input type="text" class="form-control" placeholder="Введите телефон клиента"
                                   aria-label="Телефон" name="home_phone">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary me-md-2">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
