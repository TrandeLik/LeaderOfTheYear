@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Заблокированные пользователи</h1>
            @if(count($bannedUsers) == 0)
                <p>Заблокированных пользователей нет</p>
            @endif
            @foreach($bannedUsers as $user)
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-header">{{$user -> name . ', ' . $user -> form}}</h3><br>
                        <p>{{$user -> email}}</p>
                        <confirm-action
                                    :button-class="'btn btn-warning'"
                                    :button-text="'Разблокировать'"
                                    :button-action="'/user/{{$user->id}}/unblock'"
                                    :modal-text="'Вы уверены, что хотите разблокировать пользователя {{$user->name}}?'"
                                    :id="'unblock{{$user->id}}'"
                        ></confirm-action>       
                    </div><br>
                </div><br>
            @endforeach
        </div>
    </div>
    <a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection