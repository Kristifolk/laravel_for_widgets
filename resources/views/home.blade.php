@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="padding-bottom: 10px">
                        <form class="d-flex" action="{{ route('search') }}" method="GET">
                            @csrf
                            @method('GET')
                            <input class="form-control me-2" type="search" name="last_name" placeholder="Поиск" aria-label="Поиск">
                            <button class="btn btn-outline-primary" type="submit">Поиск клиента</button>
                        </form>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a class="btn btn-primary me-md-2" href="{{ route('client.create') }}">Добавить клиента</a>
                    </div>
                    {{-- Таблица START --}}
                    <h3 class="text-primary">Клиенты ветменеджера (лимит 50)</h3>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Фамилия</th>
                            <th scope="col">Отчество</th>
                            <th class="col-1">Просмотреть</th>
                            <th class="col-1">Редактировать</th>
                            <th class="col-1">Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($firstFiftyClients as $client)
                            <tr>
                            <th>{{ $client['id'] }}</th>
                            <th>{{ $client['first_name'] }}</th>
                            <th>{{ $client['last_name'] }}</th>
                            <th>{{ $client['middle_name'] }}</th>
                            <th>
                                <a class="btn btn-primary me-md-2"
                                   href="{{ route('client.show', $client['id']) }}">Просмотреть</a>
                            </th>
                            <th>
                                <a class="btn btn-primary me-md-2" href="{{ route('client.edit', $client['id']) }}">Редактировать</a>
                            </th>
                            <th>
                                <form action="{{ route('client.destroy', $client['id']) }}" method="POST" onsubmit="return confirm('Вы действительно хотите удалить этого клиента со всеми питомцами?');">
                                    @csrf
                                    @method('DELETE')
                                    <button  type="submit" class="btn btn-primary me-md-2">Удалить</button>
                                </form>
                            </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{-- Таблица END --}}
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ route('home', ['page' => $currentPage - 1]) }}" tabindex="-1">Previous</a>
                            </li>
                            @for ($i = 1; $i <= $totalPage; $i++)
                            <li class="page-item {{ $currentPage == $i }}">
                                <a class="page-link" href="{{ route('home', ['page' => $i]) }}">{{ $i }}</a>
                            </li>
                            @endfor
                            <li class="page-item {{ $currentPage == $totalPage ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ route('home', ['page' => $currentPage + 1]) }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
