@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>События</h1>
                <div class='card'>
                    <div class='card-body'>
                    <form method="post">
                      @csrf
                      <div name="categoryDiv">
                        <select name="category" onchange="writeTypes();">
                              <option disabled selected>Категория</option>
                              @foreach ($categories as $category)
                                  <option>{{ $category->category }}</option>
                              @endforeach
                        </select>                        
                        <input type="button" name="category" onclick="changeInput('category');" value="Добавить">
                      </div>
                      <div name="typeDiv">
                        <select name="type" disabled>
                            <option disabled selected>Тип события</option>
                        </select>                        
                        <input type="button" name="type" onclick="changeInput('type');" value="Добавить">
                      </div><br>
                      <div name="stageDiv">
                        <select name="stage" class="form-control">
                              <option disabled selected>Этап</option>
                              @foreach ($stages as $stage)
                                  <option>{{ $stage->stage }}</option>
                              @endforeach
                        </select>
                        <input type="button" name="stage" onclick="changeInput('stage');" value="Добавить">
                      </div><br>
                      <div name="resultDiv">
                        <select name="result" class="form-control">
                              <option disabled selected>Результат</option>
                              @foreach ($results as $result)
                                  <option>{{ $result->result }}</option>
                              @endforeach
                        </select>                        
                        <input type="button" name="result" onclick="changeInput('result');" value="Добавить">
                      </div><br>
                      <input type="number" name="score" placeholder="Кол-во баллов" class="form-control"><br>
                      <input type="submit" value="Отправить" class="btn btn-primary">
                    </form>
                    <div name="unused" style="display:none;">
                      <input type='text' name="category" placeholder="Категория" class="form-control">
                      <input type='text' name="type" placeholder="Тип события" class="form-control">
                      <input type='text' name="stage" placeholder="Этап" class="form-control">
                      <input type='text' name="result" placeholder="Результат" class="form-control">
                    </div>
                    </div>
              </div>
        </div>
    </div>
  </div>
  <a href="{{url()->previous()}}"><button class="btn btn-primary" style="float: right">Назад</button></a>
<script>
    let achievements = [];
    @foreach ($achievementTypes as $achievementType)
        achievements.push({category: "{{$achievementType->category}}", type: "{{$achievementType->type}}", stage: "{{$achievementType->stage}}", result: "{{$achievementType->result}}"});
    @endforeach
</script>
<script src="/js/achievementSelection.js"></script>
<script>
    function writeTypes(){
      changeCategory();
      document.getElementsByName('type')[0].disabled = false;
    }

    function changeInput(name){
      let elements = document.getElementsByName(name);
      let parent = document.getElementsByName(name+'Div')[0];
      let el = parent.replaceChild(elements[2],elements[0]);
      document.getElementsByName('unused')[0].appendChild(el);
      if (elements[1].value == 'Добавить'){
        elements[1].value = 'Выбрать';
      } else {
        elements[1].value = 'Добавить';
      }
    }
</script>
@endsection
