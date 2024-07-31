@extends('layouts.app')

@section('content')
{{--    Отображение сообщений об ошибках--}}
{{--    @if ($errors->any())--}}
{{--        <div class="alert alert-danger">--}}
{{--            <ul>--}}
{{--                @foreach ($errors->all() as $error)--}}
{{--                    <li>{{ $error }}</li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    @endif--}}

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
                <form action="{{ route('client.update', $oldClientInfo['id']) }}" method="POST"
                      onsubmit="return confirm('Проверьте правильность внесенных данных клиента');">
                    @csrf
                    @method('PUT')

                    <label for="basic-url" class="text-primary">Клиент Ветменеджер</label>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Имя</span>
                        <input type="text" class="form-control" placeholder="Введите имя клиента"
                               aria-label="Имя" aria-describedby="basic-addon1" name="first_name"
                               value={{ $oldClientInfo['first_name'] }} required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Фамилия</span>
                        <input type="text" class="form-control" placeholder="Введите фамилию клиента"
                               aria-label="Имя" aria-describedby="basic-addon1" name="last_name"
                               value={{ $oldClientInfo['last_name'] }} required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Отчество</span>
                        <input type="text" class="form-control" placeholder="Введите отчество клиента"
                               aria-label="Имя" aria-describedby="basic-addon1" name="middle_name"
                               value={{ $oldClientInfo['middle_name'] }}>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Почта</span>
                        <input type="text" class="form-control" placeholder="Введите адрес электронной почты клиента"
                               aria-label="Имя" aria-describedby="basic-addon1" name="email"
                               value={{ $oldClientInfo['email'] }}>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Город</span>
                        <input type="text" class="form-control" placeholder="Введите город клиента"
                               aria-label="Город" name="city"
                               value={{ $oldClientInfo['city_data']['title'] }}>
                        <span class="input-group-text">Телефон</span>
                        <input type="text" class="form-control" placeholder="Введите телефон клиента"
                               aria-label="Телефон" name="home_phone"
                               value={{ $oldClientInfo['home_phone'] }}>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button  type="submit" class="btn btn-primary me-md-2">Сохранить</button>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection
