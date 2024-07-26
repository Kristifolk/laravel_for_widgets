@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                <form action="{{ route('pet.edit', 1) }}" method="POST" onsubmit="return confirm('Проверьте правильность внесенных данных питомца');">
                    @csrf
                    @method('PUT')

                    <label for="basic-url" class="text-primary">Питомец</label>

                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Кличка</span>
                        <input type="text" class="form-control" placeholder="Введите кличку питомца" aria-label="Кличка" aria-describedby="basic-addon1">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Вид</span>
                        <input type="text" class="form-control" placeholder="Введите вид питомца" aria-label="Вид">
                        <span class="input-group-text">Порода</span>
                        <input type="text" class="form-control" placeholder="Введите породу питомца" aria-label="Порода">
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text">Пол</span>
                        <input type="text" class="form-control" placeholder="Введите пол питомца" aria-label="Пол">
{{--                        <span class="input-group-text">Возраст</span>--}}
{{--                        <input type="text" class="form-control" placeholder="Введите возраст питомца" aria-label="Возраст">--}}
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button  type="submit" class="btn btn-primary me-md-2">Сохранить</button>
{{--                        //пет контроллер метод сторе или апдате--}}
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
