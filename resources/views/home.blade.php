@extends('layouts.app')

@section('content')

<!-- message de succès -->
<div class="container" id="logging-message">
    <div class="row justify-content-center">
        <div class="col-md-4">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
        </div>
    </div>
</div>

@if(Auth::user()->role === 'administrateur')  <!-- PARTIE SI L'UILISATEUR EST UN ADMINISTRATEUR -->

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div class="table-responsive-sm table-striped">
                <table class="table">
                    <thead>
                        <tr class='text-center'>
                            <th  class="border border-grey" scope="col">#</th>
                            <th  class="border border-grey"scope="col">Nom</th>
                            <th  class="border border-grey"scope="col">Email</th>
                            <th  class="border border-grey"scope="col">Role</th>
                            <th class="border border-grey" scope="col">Modifier</th>
                            <th class="border border-grey" scope="col">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class='text-center'>
                            <td class="border border-grey">{{$user->id}}</td>
                            <td class="border border-grey">{{$user->username}}</td>
                            <td class="border border-grey">{{$user->email}}</td>
                            <td class="border border-grey">{{$user->role}}</td>
                            <td class="border border-grey"><a href="{{ url('admin/edit/' . $user->id) }}" type="button" class="btn btn-light"><i class="fas fa-pen"></i></a></td>
                            <td class="border border-grey"><a href="{{ url('admin/delete/' . $user->id) }}" type="button" class="btn btn-light" OnClick="return confirm('Voulez-vous vraiment supprimer ?');"><i class="fas fa-trash-alt"></a></i></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ajouter un utilisateur') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('admin') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmation mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                                                
                        <div class="form-group col-md-12 d-flex flex-row-reverse">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="role" value="1" name="role">
                                <label class="form-check-label" for="role"><small>Administrateur</small></label>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Créer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif(Auth::user()->role = 'client')   <!-- PARTIE SI L'UTILISATEUR EST UN CLIENT -->
<!-- bibliothèque -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="text-center">Votre bibliothèque de photos</h1>
        </div>
    </div>

    <div class="row d-flex justify-content-center my-2">
        <div class="col-md-3">
            <input id="searchbar" type="text" placeholder="Rechercher un dossier"> 
        </div>
    </div>

    <div class="row d-flex">
        <div class="col-md-12">
        @foreach($folders as $folder)
            <a href="{{ url('/folders/' . $folder->id)}} " type="button" class="btn btn-dark linkToFolder">{{ $folder->name }}</a>
        @endforeach
        </div>
    </div>

    <div class="row justify-content-center py-3">
        <div class="col-md-3 d-flex flex-column">
            <button type="button" id="folder" class="btn btn-dark">Nouveau dossier</button>
            <div id="folderform" class="col-md-12 py-3" hidden>
                <form method="POST" action="{{ url('folders') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-12 col-form-label text-center">{{ __('Nom du dossier') }}</label>
                            
                        <div class="col-md-12">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <button type="submit" class="btn btn-dark">{{ __('Créer') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('JS')
    <script src="{{ asset('js/home.js') }}" defer></script>
@endsection