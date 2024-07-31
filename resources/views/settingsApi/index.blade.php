@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">

                        @if(!isset($settings->id))
                            <a class="btn btn-primary me-md-2" href="{{ route('settingsApi.create') }}">Добавить</a>
                        @else
                            <a class="btn btn-primary me-md-2"
                               href="{{ route('settingsApi.edit', $settings->id) }}">Изменить</a>
                        @endif

                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-primary">Настройки API</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">url</th>
                            <th scope="col">api_key</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th>{{$settings->url ?? null}}</th>
                            <th>{{$settings->api_key ?? null}}</th>
                            <th>
                                @if(isset($settings->id))
                                    <form method="POST"
                                          action="{{ route('settingsApi.destroy', Auth::user()->id) }}">
                                        @method('DElETE')
                                        @csrf
                                        <button class="btn btn-primary me-md-2" type="submit">Удалить</button>
                                    </form>
                                @endif
                            </th>

                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
