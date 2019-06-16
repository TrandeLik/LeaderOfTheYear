@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Ученики</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td scope="row"><a href="{{url('/user/' . $user -> id . '/profile')}}">{{ $user -> name.', '.$user -> form}} </a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{url('/')}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
@endsection