@extends('layouts.app')

@section('content')
    <div class="container">
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
                        <td><a href={{url('/user/'.$user->id.'/ban')}}><button class="btn btn-danger"> Заблокировать </button></a></td>
                        <td><a href={{url('/user/'.$user->id.'/promote')}}><button class="btn btn-warning"> Назначить администратором </button></a></td>
                    @endif
                    @if ($user -> role == 'admin')
                        <td scope="row"><strong>Администратор: </strong>{{ $user -> name }}</td>
                        <td><a href={{url('/user/'.$user->id.'/ban')}}><button class="btn btn-danger"> Заблокировать </button></a></td>
                        <td><a href={{url('/user/'.$user->id.'/degrade')}}><button class="btn btn-warning"> Снять с должности администратора </button></a></td>
                    @endif
                    @if ($user -> role == 'banned')
                        <td scope="row"><strong> Заблокирован: </strong>{{ $user -> name.', '.$user -> form}}</td>
                        <td><a href={{url('/user/'.$user->id.'/unblock')}}><button class="btn btn-warning"> Разблокировать </button></a></td>
                        <td></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{url('/')}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection