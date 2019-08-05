@extends('layouts.app')

@section('content')
<div class="table-responsive">
    <a href="/leaderboard/export">Экспортировать в Excel</a>
    <table class="table table-hover">
        <thead>
            <tr>
            <th scope="col">Место</th>
            <th scope="col">ФИО</th>
            <th scope="col">Класс</th>
            @if ($showScore)
                <th scope="col">Баллы</th>
            @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($leaders as $leader)
                @if ($leader->score>=$minimalAllowedScore)
                    <tr class="{{($leader->percentage()<=$awardedPercentage + $winnerPercentage) ? ($leader->percentage()<=$winnerPercentage) ? 'table-success' : 'table-warning' : ''}}">
                        <th scope="row">{{ $leader->place() }}</th>
                        <td>{{ $leader->name }}</td>
                        <td>{{ $leader->form }}</td>
                        @if ($showScore)
                            <td>{{ $leader->score }}</td>
                        @endif
                    </tr>
                @elseif ((Auth::user()->role=='superadmin') or (Auth::user()->role=='admin'))
                    <tr class="table-danger">
                        <th scope="row">{{ $leader->place() }}</th>
                        <td>{{ $leader->name }}</td>
                        <td>{{ $leader->form }}</td>
                        @if ($showScore)
                            <td>{{ $leader->score }}</td>
                        @endif
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection