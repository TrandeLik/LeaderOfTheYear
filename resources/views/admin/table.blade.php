@extends('layouts.app')

@section('content')
    <div id="app" class="row">
        <achievement-table :achievements="{{json_encode($achievements)}}"></achievement-table>
    </div>
    <a href="{{url()->previous()}}"><button class="btn btn-primary">Назад</button> </a>
@endsection