@extends('layouts.app')

@section('content')
<div class="container">
<div class="col-md-12">
    <h2>Заявки</h2>
    @if(count($sentAchievements) == 0)
        <p>На данный момент заявок нет</p>
    @else
        @foreach($sentAchievements as $achievement)
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">От пользователя {{$achievement -> user -> name}}, {{$achievement -> user -> form}}</h3>
                    <p>{{$achievement -> type.', '.$achievement -> name.', '.$achievement -> stage.', '.$achievement -> subject.', '.$achievement -> result}}</p>
                    <a href="{{'/achievement/'.$achievement->id.'/download_confirmation'}}">Подтверждение</a><br><br>
                    <a href="{{url('/achievement/'. $achievement -> id . '/confirm')}}"><button class="btn btn-success">Одобрить</button> </a>
                    <a href="{{url('/achievement/'. $achievement -> id . '/reject')}}"><button class="btn btn-danger">Отклонить</button> </a>
                </div><br>
            </div><br>
        @endforeach
    @endif
</div>
</div>
<a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection