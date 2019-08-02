@extends('layouts.app')
<style>
    .admin-comment{
        margin-right: auto;
        margin-left: 0;
        text-align: left;
    }

    .student-comment{
        margin-right: 0;
        margin-left: auto;
        text-align: right;
    }
</style>
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
                <label for="file" class="btn" style="padding: 0; margin: 0;">Добавить новый список из таблицы Excel</label>
                <input accept="
                    application/vnd.ms-excel,
                    application/vnd.ms-office,
                    application/vnd-xls,
                    application/vnd.ms-excel,
                    application/msexcel,
                    application/x-msexcel,
                    application/x-ms-excel,
                    application/x-excel,
                    application/excel,
                    application/x-dos_ms_excel,
                    application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                    application/xls,
                    application/x-xls"
                 id = "file" type="file" name="file" placeholder="Подтверждение"><br>
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
                    <div class="card" id="app">
                        <div class="card-body">
                            <h3 class="card-title">От пользователя {{$achievement -> user -> name}}, {{$achievement -> user -> form}}</h3>
                            <p>{{$achievement -> type.', '.$achievement -> name.', '.$achievement -> stage.', '.$achievement -> subject.', '.$achievement -> result}}</p>
                            <a href="{{url('/achievement/'.$achievement->id.'/download_confirmation')}}">Подтверждение</a><br>
                            @if (count($achievement->comments)!=0)
                                <div class="show-comments-link">
                                    <a href = "" data-toggle="modal" data-target="#exampleModalLong">
                                        Посмотреть комментарии
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Комментарии</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            <div class="modal-body">
                                                <div class="content">
                                                    @foreach ($achievement->comments as $comment)
                                                        @if ($comment->author=='admin')
                                                            <div class="admin-comment">
                                                                <p>Admin</p>
                                                                <p>{{$comment->text}}</p>
                                                            </div>
                                                        @else
                                                            <div class="student-comment">
                                                                <p>{{$comment->achievement->user->name}}</p>
                                                                <p>{{$comment->text}}</p>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <br>
                            <a href="{{url('/achievement/'. $achievement -> id . '/confirm')}}"><button class="btn btn-success">Одобрить</button> </a>
                            <reject-achievement :action-address="{{json_encode('/achievement/' . $achievement->id . '/reject')}}"></reject-achievement>
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
