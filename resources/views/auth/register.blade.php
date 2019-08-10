@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Регистрация') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row mb-1">
                            <label for="name" class="col-md-2 col-form-label">{{ __('ФИО:') }}</label>

                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="username" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="email" class="col-md-2 col-form-label">{{ __('E-Mail:') }}</label>

                            <div class="col-md-10">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="form" class="col-md-2 col-form-label">{{ __('Класс:') }}</label>
                            <div class="col-md-10 row" style="padding: 0 15px;">
                                <select id="form" name="form" class="form-control col-md-6 col-12">
                                        <option>11</option>
                                        <option>10</option>
                                        <option>9</option>
                                        <option>8</option>
                                        <option>7</option>
                                        <option>6</option>
                                        <option>5</option>
                                        <option>4</option>
                                        <option>3</option>
                                        <option>2</option>
                                        <option>1</option>
                                </select>
                                <select id="form" name="formLetter" class="form-control col-md-6 col-12">
                                        <option>А</option>
                                        <option>Б</option>
                                        <option>В</option>
                                        <option>Г</option>
                                        <option>Д</option>
                                        <option>Е</option>
                                        <option>Ж</option>
                                        <option>З</option>
                                        <option>И</option>
                                        <option>К</option>
                                        <option>Л</option>
                                        <option>М</option>
                                        <option>Н</option>
                                        <option>О</option>
                                        <option>П</option>
                                        <option>Р</option>
                                        <option>С</option>
                                        <option>Т</option>
                                        <option>У</option>
                                        <option>Ф</option>
                                        <option>Х</option>
                                        <option>Ц</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="password" class="col-md-2 col-form-label">{{ __('Пароль:') }}</label>

                            <div class="col-md-10">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label for="password-confirm" class="col-md-2 col-form-label">{{ __('Подтвердите пароль:') }}</label>

                            <div class="col-md-10">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="col-12 text-center">
                                <div class="">
                                    <p style="color:grey;">Нажимая на кпопку «Зарегестрироваться», я принимаю условия
                                    <a data-toggle="modal" data-target="#exampleModalLong" style="color:blue;">
                                        пользовательского соглашения
                                    </a>
                                    </p>
                                </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                                </div>
                            </div>
                            </div>
                            
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-4 offset-md-4 col-12">
                                <button type="submit" class="btn btn-primary col-12">
                                    {{ __('Зарегистрироваться') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
