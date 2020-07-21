<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use Redirect;
use App\Photo;
use App\User;
use App\Folder;

class ApiController extends Controller
{
    // Récupérer toutes les photos du répertoire
    public function getAllPhotos()
    {
        $photos = Photo::get()->toJson(JSON_PRETTY_PRINT);

        return response($photos, 200);
    }

    // Uploader une photo
    public function uploadPhoto(Request $request)
    {
        foreach($request->file('photo_path') as $photo_path){
            $user_id = Auth::user()->id;

            // Restriction de taille et d'extension des photos
            $rules = [
                'photo_path' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:1080'
            ];

            // Mise en place des messages d'erreur
            $validator = Validator::make($request->all(), [
                'photo_path.required' => 'Veuillez attacher une photo',
                'photo_path.mimes' =>'L\'extension du fichier est incorrecte',
                'photo_path.max' =>'La taille du fichier est trop importante',
            ]);

            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInputs();
            }
            
            // Création de l'entrée en bdd
            $photo = new Photo;

            // Enregistrement de la photo en local
            $photoName = Str::random(40) . "." . $photo_path->getClientOriginalExtension();
            $destinationPhotoPath = storage_path('/app/public/photos/client' . $user_id .'/' . $request->folder);
            $photo_path->move($destinationPhotoPath, $photoName);
            $photo->photo_path =  $photoName;
                
            $photo->user_id = $user_id;
            $photo->folder_id = $request->folder_id;
        
            $photo->save();
        }

        return response()->json([
            "message" => "Photo enregistrée !"
        ], 201);
    }

    // Affichage des photos d'un utilisateur
    public function getPhotoByUserId($user_id)
    {
        if(Photo::where('user_id', $user_id)->exists()){
            $photo = Photo::where('user_id', $user_id)->get()->toJson(JSON_PRETTY_PRINT);

            return response($photo, 200);
        }else{
            return response()->json([
                "message" => 'Photo not found'
            ], 404);
        }
    }

    // Modification d'une photo
    public function updatePhoto(Request $request, $id)
    {
        if(Photo::where('id', $id)->exists()){
            $photo = Photo::find($id);
            $photo->photo_path = is_null($request->file('photo_path')) ? $photo->photo_path : $request->file('photo_path');
            $photo->save();

            return response()->json([
                "message" => "record updated successfully"
            ], 200);
        }else{
            return response()->json([
                "message" => "Photo not found"
            ], 404);
        }
    }

    // Suppression d'une photo
    public function deletePhoto($id)
    {
        if(Photo::where('id', $id)->exists()){
            $photo = Photo::find($id);
            $photo->delete();

            return response()->json([
                "message" => "record deleted"
            ], 200);
        }else{
            return response()->json([
                "message" => "Photo not found"
            ], 404);
        }
    }

    // Récuperer tout les utilisateurs
    public function getAllUsers()
    {
        $users = User::get()->toJson(JSON_PRETTY_PRINT);

        return response($users, 200);
    }

    // Récupérer un utilisateur
    public function getSingleUser($id)
    {
        if(User::where('id', $id)->exists()){
            $user = User::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);

            return response($user, 200);
        }else{
            return response()->json([
                "message" => "Utilisateur non reconnu"
            ], 404);
        }
    }

    // Créer un utilisateur
    public function createUser(Request $request)
    {
            $user = new User;
            $user->username = $request->username;
            $user->role = $request->role;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();
        
            return response()->json([
                "message" => "Nouvel utilisateur créé"
            ], 201);
    }

    // Modifier d'un utilisateur
    protected function editUser(Request $request, $id)
    {
        if(User::where('id', $id)->exists()){
            $user = User::find($id);
            $user->username = is_null($request->username) ? $user->username : $request->username;
            $user->role = is_null($request->role) ? $user->role : $request->role;
            $user->email = is_null($request->email) ? $user->email : $request->email;
            $user->save();

            return response()->json([
                "message" => "Modification enregistrée"
            ], 200);
        }else{
            return response()->json([
                "message" => "Utilisateur non reconnu"
            ], 404);
        }
    }

    // Supprimer d'un utilisateur
    protected function deleteUser($id)
    {
        if(User::where('id', $id)->exists()){
            $user = User::find($id);
            $user->delete();

            return response()->json([
                "message" => "Utilisateur supprimé"
            ], 200);
        }else{
            return response()->json([
                "message" => "Utilisateur non reconnu"
            ], 404);
        }
    }
}
