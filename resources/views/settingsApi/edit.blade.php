@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <h3>Add API</h3>
                    <form method="POST" action="{{ route('settingsApi.update', Auth::user()->id) }}" >
                        @method('PUT')
                        @csrf
                        <div class="mb-3">
                            <label  class="form-label">Url</label>
                            <input type="url" name="url" class="form-control" placeholder="https://ya.ru/">
                        </div>

                        <div class="mb-3">
                            <label  class="form-label">Api Key</label>
                            <input type="text" name="api_key"  class="form-control">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-primary me-md-2" type="submit">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
