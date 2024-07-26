@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pet.store', $ownerId) }}" method="POST"
                              onsubmit="return confirm('Проверьте правильность внесенных данных питомца');">
                            @csrf
                            <input type="hidden" name="owner_id" value="{{ $ownerId }}">

                            <label for="basic-url" class="text-primary">Питомец</label>
                            <div id="pet-fields-container">
                                <div class="pet-fields">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1">Кличка</span>
                                        <input type="text" class="form-control" placeholder="Введите кличку"
                                               aria-label="Кличка" aria-describedby="basic-addon1" name="alias" required>
                                    </div>
{{--TODO выпадающий список в идеале по апи запрос,чтобы всегда актуальные данные--}}
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Вид</span>
{{--                                        <input type="text" class="form-control" placeholder="Введите вид"--}}
{{--                                               aria-label="Вид" name="type[title]">--}}
                                        <select class="form-select" aria-label="Default select example" name="type_id">
{{--                                            <option selected>Выберите вид...</option>--}}
                                            <option value="1">Кошки</option>
                                            <option value="2">Собаки</option>
                                            <option value="3">Грызуны</option>
                                            <option value="4">Птицы</option>
                                            <option value="5">Рептилии</option>
                                            <option value="6">Сельскохозяйственные</option>
                                        </select>

                                        <span class="input-group-text">Порода</span>
                                        <select class="form-select" aria-label="Default select example"
                                                id="breedId" name="breed_id">
                                        </select>
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Пол</span>
                                        <select class="form-select" aria-label="Default select example" name="sex">
                                            <option value="unknown">Не известен</option>
                                            <option value="male">Самец</option>
                                            <option value="female">Самка</option>
{{--                                            <option value="">Кастрирован</option>--}}
{{--                                            <option value="">Стерилизована</option>--}}
                                        </select>

{{--                                        <span class="input-group-text">Возраст</span>--}}
{{--                                        <input type="text" class="form-control" placeholder="Введите возраст"--}}
{{--                                               aria-label="Возраст">--}}
                                    </div>
                                </div>
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
