@extends('layouts.app')

@section('content')
<div class="container" id="login-container">
    <div class="row">
        <h1 class="text-center hidden-xs">Queremos estar más cerca de ti <br>porque nos preocupa tu bienestar.</h1>
        <h1 class="text-center visible-xs-block">Queremos estar<br> más cerca de ti <br>porque nos preocupa<br> tu bienestar.</h1>
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default" id="login-box">
                <h3 class="panel-heading text-center">Acceso a la plataforma</h3>

                <div class="panel-body text-center">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Entrar
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                ¿Has olvidado la contraseña?
                            </a>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <picture>
                        <source type="image/svg+xml" srcset="/img/logo_white.svg">
                        <img 
                            src="/img/logo_white.png"
                            alt="Logo Dentix">
                    </picture>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
