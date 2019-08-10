@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Пользователи</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    @if ($user -> role == 'student')
                        <td scope="row"><a href="{{url('/user/' . $user -> id . '/profile')}}">{{ $user -> name.', '.$user -> form}} </a></td>
                        <td>
                            <confirm-action
                                    :button-class="'btn btn-danger'"
                                    :button-text="'Заблокировать'"
                                    :button-action="'/user/{{$user->id}}/ban'"
                                    :modal-text="'Вы уверены, что хотите заблокировать пользователя {{$user->name}}?'"
                                    :id="'ban{{$user->id}}'"
                            ></confirm-action>                            
                        </td>
                        <td>
                            <confirm-action
                                    :button-class="'btn btn-warning'"
                                    :button-text="'Назначить администратором'"
                                    :button-action="'/user/{{$user->id}}/promote'"
                                    :modal-text="'Вы уверены, что хотите назначить пользователя {{$user->name}} администратором?'"
                                    :id="'promote{{$user->id}}'"
                            ></confirm-action>                            
                        </td>
                    @endif
                    @if ($user -> role == 'admin')
                        <td scope="row"><strong>Администратор: </strong>{{ $user -> name }}</td>
                        <td>
                            <confirm-action
                                    :button-class="'btn btn-danger'"
                                    :button-text="'Заблокировать'"
                                    :button-action="'/user/{{$user->id}}/ban'"
                                    :modal-text="'Вы уверены, что хотите заблокировать администратора {{$user->name}}?'"
                                    :id="'ban{{$user->id}}'"
                            ></confirm-action>       
                        </td>
                        <td>
                            <confirm-action
                                    :button-class="'btn btn-warning'"
                                    :button-text="'Разжаловать'"
                                    :button-action="'/user/{{$user->id}}/degrade'"
                                    :modal-text="'Вы уверены, что хотите разжаловать администратора {{$user->name}}?'"
                                    :id="'degrade{{$user->id}}'"
                            ></confirm-action>       
                        </td>
                    @endif
                    @if ($user -> role == 'banned')
                        <td scope="row"><strong> Заблокирован: </strong>{{ $user -> name.', '.$user -> form}}</td>
                        <td>
                            <confirm-action
                                    :button-class="'btn btn-warning'"
                                    :button-text="'Разблокировать'"
                                    :button-action="'/user/{{$user->id}}/unblock'"
                                    :modal-text="'Вы уверены, что хотите разблокировать пользователя {{$user->name}}?'"
                                    :id="'unblock{{$user->id}}'"
                            ></confirm-action>       
                        </td>
                        <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection