@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
    @foreach($users as $user)
        <div class="col-md-12">
           <form method="POST" action="{{ url('/account/' . $user->id) }}" enctype="multipart/form-data">
                @csrf 
                <input type="text" name="id" value="{{ $user->id }}" hidden>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="username" class="col-md-8 col-form-label">{{ __('Nom') }}</label>
                        <input id="username" type="text" name="username" class="form-control {{ $errors->has('username') ? 'has-error' : '' }}" value="{{ $errors->has('username') ? old(username) : $user->username }}" autocomplete="username" autofocus>
                    
                        @if ( $errors->has('username') )
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="email" class="col-md-8 col-form-label">{{ __('email') }}</label>
                        <input id="email" type="text" name="email" class="form-control {{ $errors->has('email') ? 'has-error' : '' }}" value="{{ $errors->has('email') ? old(email) : $user->email }}" autocomplete="email" autofocus>
                    
                        @if ( $errors->has('email') )
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="watermark" class="col-form-label">{{ __('Ajouter votre watermark') }}</label>
                        <input type="file" class="form-control-file {{ $errors->has('watermark') ? 'has-error' : ' '}}" name="watermark">

                        @if ( $errors->has('watermark') )
                            <span class="help-block">
                                <strong>{{ $errors->first('watermark') }}</strong> 
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-dark mx-1">{{ __('Modifier') }}</button>
                    </div>
                </div>
           </form>
        </div>
        <div class="col-md-12 my-2">
            <a href="{{ route('password.request') }}" type="button" class="btn btn-dark">Voulez-vous changer de mot de passe ?</a>
        </div>
        <div class="col-md-12 d-flex flex-row-reverse">
            <a type="button" class="btn btn-dark" href="{{ route('home') }}">Retour</a>
        </div>
    @endforeach
    </div>
</div>

@endsection