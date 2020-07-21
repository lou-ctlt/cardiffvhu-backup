@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-flex flex-row-reverse">
        <div class="col-md-2">
            <a type="button" class="btn btn-dark" href="{{ url()->previous() }}">Retour</a>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
        @foreach($folders as $folder)
        @foreach($photos as $photo)
            <img src="\storage\photos\Client{{$photo->user_id}}\{{$folder->name}}\{{$photo->photo}}" alt="singlephoto" style="width:100%;">
        @endforeach
        @endforeach
        </div>
    </div>
</div>

@endsection