@extends('layouts.app')
<style>
    .btn-success{
        margin-top: 20px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-10">
            <div class="card border-success">
                <div class="card-header">Добавление достижения</div>
                <div class="card-body">
                    <form method="POST" class="row col-12 justify-content-center" enctype="multipart/form-data">
                        @csrf
                        <select name="category" onchange="changeStage(); changeType(); changeCategory();">
                            <option selected disabled>Категория</option>
                            @foreach ($categories as $category)
                                <option>{{ $category->category }}</option>
                            @endforeach
                        </select>
                        <select name="type" onchange = "changeStage(); changeType();" disabled>
                            <option selected disabled>Тип</option>
                        </select>
                        <input type="text" name="name" placeholder="Название олимпиады">
                        <input type="text" name="subject" placeholder="Предмет">
                        <select name="stage" onchange = "changeStage();" disabled>
                            <option selected disabled>Этап</option>
                        </select>
                        <select name="result" disabled>
                            <option selected disabled>Результат</option>
                        </select>
                        <label for="file" class="btn">Подтверждение</label>
                        <input id = "file" type="file" name="file" placeholder="Подтверждение"><br>
                        <input type="submit" value="Добавить" class="btn btn-success col-4">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let achievements = [];
    @foreach ($achievement_types as $achievement_type)
        achievements.push({category: "{{$achievement_type->category}}", type: "{{$achievement_type->type}}", stage: "{{$achievement_type->stage}}", result: "{{$achievement_type->result}}"});
    @endforeach
    function changeCategory(){
        let currentAchievements = achievements.slice();
        let types = [];
        let index = document.getElementsByName('category')[0].options.selectedIndex;
        let category = document.getElementsByName('category')[0].options[index].value;
        currentAchievements = currentAchievements.filter(function(item){
            if ((item['category'] == category) & (types.indexOf(item['type'])==-1)){
                types.push(item['type']);
                return true;
            } else {
                return false;
            }
        });
        document.getElementsByName('type')[0].options.length = types.length+1;
        for (let i = 0; i < types.length; i++){
            document.getElementsByName('type')[0].options[i+1].text = types[i];
            document.getElementsByName('type')[0].options[i+1].value = types[i];
        }
        document.getElementsByName('type')[0].disabled = false;
        document.getElementsByName('stage')[0].disabled = true;
        document.getElementsByName('result')[0].disabled = true;
        document.getElementsByName('type')[0].options[0].selected = true;
        document.getElementsByName('stage')[0].options[0].selected = true;
        document.getElementsByName('result')[0].options[0].selected = true;
    }

    function changeType(){
        let currentAchievements = achievements.slice();
        let stages = [];
        let index = document.getElementsByName('category')[0].options.selectedIndex;
        let category = document.getElementsByName('category')[0].options[index].value;
        index = document.getElementsByName('type')[0].options.selectedIndex;
        let type = document.getElementsByName('type')[0].options[index].value;
        currentAchievements = currentAchievements.filter(function(item){
            if ((item['category'] == category) & (item['type'] == type) & (stages.indexOf(item['stage'])==-1)){
                stages.push(item['stage']);
                return true;
            } else {
                return false;
            }
        });
        document.getElementsByName('stage')[0].options.length = stages.length+1;
        for (let i = 0; i < stages.length; i++){
            document.getElementsByName('stage')[0].options[i+1].text = stages[i];
            document.getElementsByName('stage')[0].options[i+1].value = stages[i];
        }
        document.getElementsByName('stage')[0].disabled = false;
        document.getElementsByName('result')[0].disabled = true;
        document.getElementsByName('stage')[0].options[0].selected = true;
        document.getElementsByName('result')[0].options[0].selected = true;
    }

    function changeStage(){
        let currentAchievements = achievements.slice();
        let results = [];
        let index = document.getElementsByName('category')[0].options.selectedIndex;
        let category = document.getElementsByName('category')[0].options[index].value;
        index = document.getElementsByName('type')[0].options.selectedIndex;
        let type = document.getElementsByName('type')[0].options[index].value;
        index = document.getElementsByName('stage')[0].options.selectedIndex;
        let stage = document.getElementsByName('stage')[0].options[index].value;
        currentAchievements = currentAchievements.filter(function(item){
            if ((item['category'] == category) & (item['type'] == type) & (item['stage'] == stage) & (results.indexOf(item['result'])==-1)){
                results.push(item['result']);
                return true;
            } else {
                return false;
            }
        });
        console.log(results);
        document.getElementsByName('result')[0].options.length = results.length+1;
        for (let i = 0; i < results.length; i++){
            document.getElementsByName('result')[0].options[i+1].text = results[i];
            document.getElementsByName('result')[0].options[i+1].value = results[i];
        }
        document.getElementsByName('result')[0].disabled = false;
        document.getElementsByName('result')[0].options[0].selected = true;
    }        
    
</script>
@endsection
