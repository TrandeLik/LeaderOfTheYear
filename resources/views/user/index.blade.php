@extends('layouts.app')
<style>
    .card{
        margin-bottom:20px;
    }
    .btn-primary{
        float:right;
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
                        <p style="color: firebrick;">
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
                     @if($isStatisticsWorking)
                        <p>Вы на {{$place}} месте</p>
                        <p>Вы входите в {{$percentage}} процентов лучших</p>
                     @endif
                </div>
            </div>
            <div class="card border-primary">
                <div class="card-header">Мои олимпиады<a href="{{url('/achievement/add/new')}}"><button class="btn btn-primary">Добавить</button></a></div>
                <div class="card-body">
                    @if ($createdAchievements != [])
                        <achievement-table :achievements="{{json_encode($createdAchievements)}}" :is_admin="false" :section="'created'"></achievement-table>
                    @else
                        <p>Здесь пусто :)</p>
                    @endif
                </div>
            </div>
            <div class="card border-danger">
                <div class="card-header">Отклоненные</div>
                <div class="card-body">
                    @if ($rejectedAchievements != [])
                        <achievement-table :achievements="{{json_encode($rejectedAchievements)}}" :is_admin="false" :section="'rejected'"></achievement-table>
                    @else
                        <p>Здесь пусто :)</p>
                    @endif
                </div>
            </div>
            <div class="card border-secondary">
                <div class="card-header">Ожидают одобрения</div>
                <div class="card-body">
                    @if ($sentAchievements != [])
                        <achievement-table :achievements="{{json_encode($sentAchievements)}}" :is_admin="false" :section="'sent'"></achievement-table>
                    @else
                        <p>Здесь пусто :)</p>
                    @endif
                </div>
            </div>
            <div class="card border-success">
                <div class="card-header">Одобренные</div>
                <div class="card-body">
                    @if ($confirmedAchievements != [])
                        <achievement-table :achievements="{{json_encode($confirmedAchievements)}}" :is_admin="false" :section="'confirmed'"></achievement-table>
                    @else
                        <p>Здесь пусто :)</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
