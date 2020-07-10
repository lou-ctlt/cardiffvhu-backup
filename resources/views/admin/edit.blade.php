@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
    @foreach($users as $user)
        <div class="col-md-12">
           <form method="POST" action="{{ url('admin/edit/' . $user->id) }}" enctype="multipart/form-data">
                @csrf 
                <input type="text" name="id" value="{{ $user->id }}" hidden>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-3">
                        <label for="name" class="col-md-8 col-form-label">{{ __('Nom') }}</label>
                        <input id="name" type="text" name="name" class="form-control {{ $errors->has('name') ? 'has-error' : '' }}" value="{{ $errors->has('name') ? old(name) : $user->name }}" autocomplete="name" autofocus>
                    
                        @if ( $errors->has('name') )
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-3">
                        <label for="email" class="col-md-8 col-form-label">{{ __('email') }}</label>
                        <input id="email" type="text" name="email" class="form-control {{ $errors->has('email') ? 'has-error' : '' }}" value="{{ $errors->has('email') ? old(email) : $user->email }}" autocomplete="email" autofocus>
                    
                        @if ( $errors->has('email') )
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="form-group col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="role" value="1" name="role" checked>
                            <label class="form-check-label" for="role"><small>Administrateur</small></label>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="role" value="2" name="role">
                            <label class="form-check-label" for="role"><small>Utilisateur</small></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 offset-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-dark mx-1">{{ __('Modifier') }}</button>
                    <a type="button" class="btn btn-dark" href="{{ route('home') }}">Retour</a>
                </div>
           </form>
        </div>
    @endforeach
    </div>
</div>

@endsection