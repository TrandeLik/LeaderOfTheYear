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
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                            Отклонить
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Отклонение заявки</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                            <div class="modal-body">
                                                <div class="accordion" id="accordionExample">
                                                    Вы действительно хотите отклонить эту заявку? 
                                                    <a style="color:blue;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Оставьте комментарий с объяснением вашего решения</a>
                                                    <div id="collapseOne" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                        <form method="POST" action="{{url('/achievement/'. $achievement -> id . '/reject')}}" id="1">
                                                            {{ csrf_field() }} 
                                                            <textarea name="comment" placeholder = "Комментарий"></textarea>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Отмена</button>
                                                <input type="submit" class="btn btn-danger" value="Отклонить" form="1">
                                            </div>
                                        </form>
                                </div>
                            </div>
                            </div>
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
