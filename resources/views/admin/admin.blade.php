@extends('layouts.app')

@section('content')

    <div class="row pl-0">
        <div class="col-md-3">
            <h2>Достижения</h2>
                <div class='card'>
                    <div class='card-body'>
                        <ul>
                            @foreach($allTypes as $type)
                                <li>{{$type -> category.', '.$type -> type.', '.$type -> stage}}</li>
                            @endforeach
                        </ul>
                        <a href="{{url('/achievement_types/all')}}">Все достижения</a><br>
                    </div>
              </div><br>
            <a href="{{url('/achievement_type/add')}}">Добавить событие</a><br><br>
            <a href="{{url('/achievement_types/download_file')}}">Текущий список достижений</a><br><br>
            <form method="post" enctype="multipart/form-data">
                @csrf
                <label for="file" class="btn" style="padding: 0; margin: 0;">Добавить новый список</label>
                <input id = "file" type="file" name="file" placeholder="Подтверждение"><br>
                <input type="submit" value="Добавить">
            </form>
        </div>
        <div class="col-md-6">
            <h2>
                Заявки
                <a href="{{url('achievements/all')}}"><button class="btn btn-success">Все достижения учеников</button></a>
            </h2>
            @if(count($sentAchievements) == 0)
                <p>На данный момент заявок нет</p>
            @else
                @foreach($sentAchievements as $achievement)
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">От пользователя {{$achievement -> user -> name}}, {{$achievement -> user -> form}}</h3>
                            <p>{{$achievement -> type.', '.$achievement -> name.', '.$achievement -> stage.', '.$achievement -> subject.', '.$achievement -> result}}</p>
                            <a href="{{url('/achievement/'.$achievement->id.'/download_confirmation')}}">Подтверждение</a><br><br>
                            <a href="{{url('/achievement/'. $achievement -> id . '/confirm')}}"><button class="btn btn-success">Одобрить</button> </a>
                            <a href="{{url('/achievement/'. $achievement -> id . '/reject')}}"><button class="btn btn-danger">Отклонить</button> </a>
                        </div><br>
                    </div><br>
                @endforeach
                <a href="{{url('/achievements/sent')}}">Все заявки</a>
            @endif
        </div>
        <div class="col-md-3">
            <h2>Участники</h2>
            <div class="card">
                <div class="card-body">
                    @foreach($students as $student)
                        <li>
                            <a href="{{url('/user/' . $student -> id . '/profile')}}">{{$student -> name . ', ' . $student -> form}}</a>
                        </li>
                    @endforeach<br>
                    <a href="{{url('/users/all')}}">Все участники</a>
                </div>
            </div><br>
            <a href="{{url('/users/banned')}}">Заблокированные пользователи</a>
        </div>
    </div>
@endsection
