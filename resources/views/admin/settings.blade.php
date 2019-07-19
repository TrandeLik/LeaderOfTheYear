@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card border-success">
                    <div class="card-header">Настройки</div>
                    <div class="card-body">
                        <form method="POST">
                            @csrf
                            @foreach ($settings as $setting)
                                <div class="form-group row">
                                    <label for="{{$setting->id}}" class="col-md-4 col-form-label text-md-right">{{$setting->name}}</label>
                                    @if ($setting->type=='on/off')
                                    <input type="checkbox" id="{{$setting->id}}" {{ ($setting->value == 'on') ? 'checked' : null }}>
                                    @elseif ($setting->type=='globalVariable')
                                    <input type="text" id="{{$setting->id}}" value="{{$setting->value}}">
                                @endif
                                </div>
                            @endforeach
                            <input type="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection