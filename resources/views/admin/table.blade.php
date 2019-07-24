@extends('layouts.app')

@section('content')
    <div id="app">
        <achievement-table :achievements="{{json_encode($achievements)}}" :is_admin="true"></achievement-table>
    </div>
    <a href="{{url()->previous()}}"><button class="btn btn-primary">Назад</button> </a>
@endsection