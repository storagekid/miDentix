@extends('layouts.app-no-auth')

@section('content')
<div class="" id="login-container">
    <div class="fx fx-100 fx-col">
        <div class="fx fx-100 fx-center">
            <div class="" id="login-box">
                <h3 class="panel-heading text-center">Selecciona un perfil</h3>

                <div class="panel-body text-center">
                    <form method="POST" action="{{ route('profile-choice') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="profile-index" class="control-label">Perfil</label>
                            <div class="styled-select white semi-square">
                                <select name="profile-index">
                                    @foreach(auth()->user()->profiles as $index => $profile)
                                    <option value="{{$index}}">
                                        {{ $profile->full_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">
                                Confirmar
                            </button>
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
