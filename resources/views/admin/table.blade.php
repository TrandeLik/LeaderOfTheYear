@extends('layouts.app')

@section('content')

    <div id="app">
        @if ($achievements !== [])
            <achievement-table :achievements="{{json_encode($achievements)}}" :is_admin="true"></achievement-table>
        @else
            <div class="alert alert-primary">
                <p>Здесь ничего нет :)</p>
            </div>
        @endif
    </div>
    <a href="{{url()->previous()}}"><button class="btn btn-primary">Назад</button> </a>
@endsection