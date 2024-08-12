@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>Ошибка API</h2>
                    <p>{{ $exception }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
