@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>События</h2>
                <div class='card'>
                    <div class='card-body'>
                    <form method="post">
                      @csrf
                      <input type='text' name="type" placeholder="Тип события" class="form-control"><br>
                      <input type="text" name="stage" placeholder="Этап" class="form-control"><br>
                      <input type="text" name="result" placeholder="Результат" class="form-control"><br>
                      <input type="number" name="score" placeholder="Кол-во баллов" class="form-control"><br>
                      <input type="submit" value="Отправить" class="btn btn-primary">
                    </form>
                    </div>
              </div>
        </div>
    </div>
  </div>
@endsection
