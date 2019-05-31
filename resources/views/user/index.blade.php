@extends('layouts.app')
<style>
    .card{
        margin-bottom:20px;
    }
    .btn-primary{
        float:right;
    }
</style>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-primary">
                <div class="card-header">Мои олимпиады<a href="/add_achievement"><button class="btn btn-primary">Добавить</button></a></div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Этап</th>
                                <th>Результат</th>
                                <th>Баллы</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($achievements as $achievement)
                            @if ($achievement->status=='created')
                                <tr>
                                    <td>{{$achievement->name}}</td>
                                    <td>{{$achievement->stage}}</td>
                                    <td>{{$achievement->result}}</td>
                                    <td>{{$achievement->score}}</td>
                                    <td><button class="btn btn-warning">Редактировать</button></td>
                                    <td><button class="btn btn-danger">Удалить</button></td>
                                    <td><a href={{ url('/user/achievement/' . $achievement->id . '/send')}}><button class="btn btn-success">Отправить</button></a></td>
                                <tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card border-danger">
                <div class="card-header">Отклоненные</div>
                <div class="card-body">

                </div>
            </div>
            <div class="card border-secondary">
                <div class="card-header">Ожидают одобрения</div>
                <div class="card-body">
                <table class="table">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Этап</th>
                                <th>Результат</th>
                                <th>Баллы</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($achievements as $achievement)
                            @if ($achievement->status=='sent')
                                <tr>
                                    <td>{{$achievement->name}}</td>
                                    <td>{{$achievement->stage}}</td>
                                    <td>{{$achievement->result}}</td>
                                    <td>{{$achievement->score}}</td>
                                <tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card border-success">
                <div class="card-header">Одобренные</div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
