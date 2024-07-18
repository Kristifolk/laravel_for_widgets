@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('client.store', 1) }}" method="POST"
                              onsubmit="return confirm('Проверьте правильность внесенных данных клиента7');">
                            @csrf
                            @method('POST')
{{--                            @method('POST')--}}

                            <label for="basic-url" class="text-primary">Клиент Ветменеджер</label>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Имя</span>
                                <input type="text" class="form-control" placeholder="Введите имя клиента"
                                       aria-label="Имя" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Фамилия</span>
                                <input type="text" class="form-control" placeholder="Введите фамилию клиента"
                                       aria-label="Имя" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Отчество</span>
                                <input type="text" class="form-control" placeholder="Введите отчество клиента"
                                       aria-label="Имя" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Почта</span>
                                <input type="text" class="form-control"
                                       placeholder="Введите адресс электронной почты клиента" aria-label="Имя"
                                       aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text">Город</span>
                                <input type="text" class="form-control" placeholder="Введите город клиента"
                                       aria-label="Город">
                                <span class="input-group-text">Телефон</span>
                                <input type="text" class="form-control" placeholder="Введите телефон клиента"
                                       aria-label="Телефон">
                            </div>
                            <label for="basic-url" class="text-primary">Питомец</label>
                            <div id="pet-fields-container">
                                <div class="pet-fields">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Кличка</span>
                                        <input type="text" class="form-control" placeholder="Введите кличку питомца"
                                               aria-label="Кличка" aria-describedby="basic-addon1">
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Вид</span>
                                        <input type="text" class="form-control" placeholder="Введите вид питомца"
                                               aria-label="Вид">
                                        <span class="input-group-text">Порода</span>
                                        <input type="text" class="form-control" placeholder="Введите породу питомца"
                                               aria-label="Порода">
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Окрас</span>
                                        <input type="text" class="form-control" placeholder="Введите окрас питомца"
                                               aria-label="Окрас">
                                        <span class="input-group-text">Возраст</span>
                                        <input type="text" class="form-control" placeholder="Введите возраст питомца"
                                               aria-label="Возраст">
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" class="btn btn-secondary me-md-2" id="add-pet-button">Добавить Питомца</button>

                                <button type="submit" class="btn btn-primary me-md-2">Сохранить</button>
                                {{--                        //клиент контроллер метод сторе или апдате--}}

                                {{--                        //пет контроллер метод сторе или апдате--}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endsection
{{--            @push('scripts')--}}
{{--                <script>--}}
{{--                   --}}
{{--                </script>--}}

{{--    @endpush--}}
            @push('scripts')
                @vite(['resources/js/addPet.js'])
            @endpush
