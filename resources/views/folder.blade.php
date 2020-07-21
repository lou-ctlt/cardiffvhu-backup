@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-flex flex-column">
        <div class="col-md-12">
            <form method="GET" action="{{ url('/photos/delete') }}" enctype="multipart/form-data">
                @csrf
                <div class="row form-group-row d-flex">
                @foreach($photos as $photo)
                @foreach($folders as $folder)
                    <div class="col-md-3 col-6">
                        <label class="image-checkbox">
                            <img    src="\storage\photos\Client{{$photo->user_id}}\{{$folder->name}}\{{$photo->photo}}"
                                    alt="photo" style="width:100%;" class="photos">
                            <input name="id[]" value="{{ $photo->id }}" type="checkbox" multiple>
                            <a href="{{ url('photos/' . $folder->id . '/' .  $photo->id) }}" style="float:right;" class="btn btn-light"><i class="fas fa-search"></i></a>
                        </label>
                    </div>
                @endforeach
                @endforeach
                </div>
                <div class="col-md-12 d-flex flex-row-reverse">
                    <button type="submit"  id="deletephotos" class="btn btn-danger" OnClick="return confirm('Voulez-vous vraiment supprimer ?');"
                    >{{ __('Supprimer la sélection') }}</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-dark my-3" id="photo">Ajouter une photo</button>
            <form method="POST" action="{{ url('/photos') }}" enctype="multipart/form-data" id="photoform" hidden>
                @csrf 
                @foreach($folders as $folder)
                    <input type="text" name="folder_id" value="{{ $folder->id }}" hidden>
                    <input type="text" name="folder" value="{{ $folder->name }}" hidden>
                @endforeach
                <div class="form-group row">
                    <div class="col-md-6 offset-md-3">
                        <label for="photo" class="col-md-8 col-form-label">{{ __('Selectionnez votre photo') }}</label>
                        <input type="file" class="form-control-file {{ $errors->has('photo') ? 'has-error' : ' '}}" name="photo[]" multiple>

                        @if ( $errors->has('photo') )
                            <span class="help-block">
                                <strong>{{ $errors->first('photo') }}</strong> 
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row d-flex justify-content-center">
                    <div class="form-check col-md-6">
                        <input class="form-check-input" type="checkbox" id="watermark" value="1" name="watermark">
                        <label class="form-check-label" for="watermark"><small>Ajouter le watermark</small></label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3 my-1">
                    <button type="submit" class="btn btn-dark">{{ __('Envoyer') }}</button>
                </div>
            </form>
        </div>
        <div class="col-md-12 d-flex flex-row-reverse">
            <a type="button" class="btn btn-dark" href="{{ route('home') }}">Retour</a>
            @foreach($folders as $folder)
            <a href="{{ url('folders/delete/' . $folder->id) }}" type="button" class="btn btn-dark mx-1" OnClick="return confirm('Voulez-vous vraiment supprimer ?');">Supprimer le dossier</a>
            @endforeach
        </div>
    </div>
</div>

@endsection

@section('JS')
    <script src="{{ asset('js/home.js') }}" defer></script>
@endsection