@extends('layouts.app')
<style>
    .card{
        margin-bottom:20px;
    }
    .btn-primary{
        float:right;
    }
    .warning{
        color:firebrick;
    }
</style>
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div id="app" class="col-md-10">
            <div class="card">
                <div class="card-header">Статистика</div>
                <div class="card-body">
                    @if (count($falseCategories)!=0)
                        <p class="warning">
                            Ваши баллы за достижения в
                            @if(count($falseCategories)==1)
                                категории
                            @else
                                категориях
                            @endif
                            @foreach ($falseCategories as $category)
                                {{$category}}
                            @endforeach
                            превышают баллы за {{$mainCategory}}. Лишние баллы учтены не будут
                        </p>
                    @endif
                    <p>Сейчас у Вас {{$confirmedScore}} подтверждённых баллов<p>
                    <p>Если все Ваши достижения будут одобрены, Вы получите {{$totalScore}} баллов</p>
                        @if (($isStatisticsWorking) and (Auth::user()->confirmedScore()>=$minimalAllowedScore))
                            <p>Вы на {{$place}} месте</p>
                            <p>Вы входите в {{$percentage}} процентов лучших</p>
                        @elseif (Auth::user()->confirmedScore()<$minimalAllowedScore)
                            <p class="warning">Ваших подтверждённых баллов недостаточно для участия в конкурсе. Количество баллов, которое вам ещё нужно набрать для попадания в рейтинг: {{$minimalAllowedScore - Auth::user()->confirmedScore()}}</p>
                        @endif
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header">Мои олимпиады<a href="{{url('/achievement/add/new')}}"><button class="btn btn-primary">Добавить</button></a></div>
                <div class="card-body">
                    @if ($achievements != [])
                        <achievement-table :achievements="{{json_encode($achievements)}}" :is_admin="false" :section="'created'"></achievement-table>
                    @else
                        <p>Здесь пусто :)</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
