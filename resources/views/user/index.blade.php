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
            <div class="card">
                <div class="card-header">Статистика
                
                </div>
                <div class="card-body">
                    @if (count($falseCategories)!=0)
                        <p style="color: firebrick;">
                            Ваши баллы за достижения в 
                            @if(count($falseCategories)==1)
                                категории
                            @else
                                категориях
                            @endif
                            @foreach ($falseCategories as $category)
                                {{$category}} 
                            @endforeach
                            превышают баллы за Интеллектуальные соревнования. Лишние баллы учтены не будут
                        </p>
                    @endif
                    <p>Сейчас у Вас {{$confirmedScore}} подтверждённых баллов<p>
                    <p>Если все Ваши достижения будут одобрены, Вы получите {{$totalScore}} баллов</p>
                    <p>Вы на {{$place}} месте</p>
                    <p>Вы входите в {{$percentage}} процентов лучших</p>
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header">Мои олимпиады<a href="/achievement/add"><button class="btn btn-primary">Добавить</button></a></div>
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
                                    <td><a href={{ url('/achievement/' . $achievement->id . '/edit')}}><button class="btn btn-warning">Редактировать</button></a></td>
                                    <td><a href={{ url('/achievement/' . $achievement->id . '/delete')}}><button class="btn btn-danger">Удалить</button></a></td>
                                    <td><a href={{ url('/achievement/' . $achievement->id . '/send')}}><button class="btn btn-success">Отправить</button></a></td>
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
                            @if ($achievement->status=='rejected')
                                <tr>
                                    <td>{{$achievement->name}}</td>
                                    <td>{{$achievement->stage}}</td>
                                    <td>{{$achievement->result}}</td>
                                    <td>{{$achievement->score}}</td>
                                    <td><a href={{ url('/achievement/' . $achievement->id . '/edit')}}><button class="btn btn-warning">Редактировать</button></a></td>
                                    <td><a href={{ url('/achievement/' . $achievement->id . '/delete')}}><button class="btn btn-danger">Удалить</button></a></td>
                                    <td><a href={{ url('/achievement/' . $achievement->id . '/send')}}><button class="btn btn-success">Отправить</button></a></td>
                                <tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
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
                                <th></th>
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
                                    <td><a href={{ url('/achievement/' . $achievement->id . '/return')}}><button class="btn btn-info" style="color:white;">Отозвать</button></a></td>
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
                            @if ($achievement->status=='confirmed')
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
        </div>
    </div>
</div>
@endsection
