@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-header">{{$user -> name . ', ' . $user -> form}}</h1><br>
                    <h4 class="card-subtitle">Cтатистика:</h4>
                    <ul>
                        <li>Количество достижений {{$userAchievements -> count()}}</li>
                        <li>Количество баллов {{$userAchievements -> sum('score')}}</li>
                        <li>Место в конкурсе: {{$place}}</li>
                    </ul>
                    @if ($user -> role == 'student')
                        <confirm-action
                                    :button-class="'btn btn-danger'"
                                    :button-text="'Заблокировать'"
                                    :button-action="'/user/{{$user->id}}/ban'"
                                    :modal-text="'Вы уверены, что хотите заблокировать пользователя {{$user->name}}?'"
                                    :id="'ban{{$user->id}}'"
                        ></confirm-action>      
                        @if (Auth::user()->role=='superadmin') 
                            <confirm-action
                                        :button-class="'btn btn-warning'"
                                        :button-text="'Назначить администратором'"
                                        :button-action="'/user/{{$user->id}}/promote'"
                                        :modal-text="'Вы уверены, что хотите назначить пользователя {{$user->name}} администратором?'"
                                        :id="'promote{{$user->id}}'"
                                ></confirm-action>    
                        @endif    
                    @endif
                    @if ($user -> role == 'banned')
                        <confirm-action
                                    :button-class="'btn btn-warning'"
                                    :button-text="'Разблокировать'"
                                    :button-action="'/user/{{$user->id}}/unblock'"
                                    :modal-text="'Вы уверены, что хотите разблокировать пользователя {{$user->name}}?'"
                                    :id="'unblock{{$user->id}}'"
                        ></confirm-action>       
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <h2>Достижения</h2>
            @if($achievements !== [])
                    <achievement-table :achievements="{{json_encode($achievements)}}" :is_admin="true" :section="'profile'"></achievement-table>
            @else
                <p>Здесь пока пусто</p>
            @endif
        </div>
    </div><br>
    <a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>

@endsection
