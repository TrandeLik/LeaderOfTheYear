@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-header">{{$user -> name . ', ' . $user -> form}}</h1><br>
                    <h4 class="card-subtitle">Cтатистика:</h4>
                    <ul>
                        <li>Количество достижений {{$confirmedAchievements -> count()}}</li>
                        <li>Количество баллов {{$confirmedAchievements -> sum('score')}}</li>
                        <li>Место в конкурсе: {{$place}}</li>
                    </ul>
                    @if ($user -> role == 'student')
                        <a href={{url('/user/'.$user->id.'/ban')}}><button class="btn btn-danger"> Заблокировать </button></a>
                        <a href={{url('/user/'.$user->id.'/promotion')}}><button class="btn btn-warning"> Назначить администратором </button></a>
                    @endif
                    @if ($user -> role == 'admin' && \Illuminate\Support\Facades\Auth::user()->role == 'superadmin')
                        <a href={{url('/user/'.$user->id.'/ban')}}><button class="btn btn-danger"> Заблокировать </button></a>
                        <a href={{url('/user/'.$user->id.'/degrade')}}><button class="btn btn-warning"> Снять с должности администратора </button></a>
                    @endif
                    @if ($user -> role == 'banned')
                        <a href={{url('/user/'.$user->id.'/unblock')}}><button class="btn btn-warning"> Разблокировать </button></a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <h2>Достижения</h2>
            @if(count($confirmedAchievements) == 0)
                <p>Здесь пока пусто</p>
            @endif
            @foreach($confirmedAchievements as $achievement)
                <div class="alert alert-info">
                    {{$achievement -> type.', '.$achievement -> name.', '.$achievement -> stage.', '.$achievement -> subject.', '.$achievement -> result}}<br><br>
                    <a href="{{url('/achievement/'. $achievement -> id . '/reject')}}"><button class="btn btn-danger">Отклонить</button></a>
                </div>
            @endforeach
        </div>
    </div><br>
    <a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>

@endsection
