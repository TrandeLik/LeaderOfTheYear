@extends('layouts.app')

@section('content')
<div class="container">
    <a href="/leaderboard/export">Экспортировать в Excel</a>
    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">Место</th>
            <th scope="col">ФИО</th>
            <th scope="col">Класс</th>
            <th scope="col">Баллы</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leaders as $leader)
                <tr class={{($leader->percentage()<=$awardedPercentage) ? ($leader->percentage()<=$winnerPercentage) ? 'table-success' : 'table-warning' : ''}}>
                    <th scope="row">{{ $leader->place() }}</th>
                    <td>{{ $leader->name }}</td>
                    <td>{{ $leader->form }}</td>
                    <td>{{ $leader->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection