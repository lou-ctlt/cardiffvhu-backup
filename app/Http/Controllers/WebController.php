<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Photo;
use App\User;
use App\Folder;
use Image;

class WebController extends Controller
{
    // Afficher la page dossier
    public function getFolder(Request $request)
    {
        $folder_id = $request->folder_id;
        $folders = Folder::where('id', $folder_id)->get();
        $photos = Photo::where('folder_id', $folder_id)->get();

        return view('folder')->with('folders', $folders)->with('photos', $photos);
    }

    // Créer un nouveau dossier
    public function createFolder(Request $request)
    {
        $user_id = Auth::user()->id;

        // Règles
        $rules = [
            'name' => 'required|string|max:255|unique',
        ];

        // Mise en place des messages d'erreur
        $validator = Validator::make($request->all(), [
            "name.required" => "Le nom du dossier est obligatoire",
            "name.string" => "Le nom du dossier doit être une chaîne de caractères",
            "name.max" => "Le nom du dossier est trop long ( max:255 caractères)",
            "name.unique" => "Ce nom de dossier existe déjà"
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInputs();
        }

        // Création de l'entrée en bdd
        $folder = new Folder;

        $folder->user_id = $user_id;
        $folder->name = $request->name;

        $folder->save();

        return Redirect::back()->with('success', 'Dossier créé !');
    }

    // Supprimer un dossier
    public function deleteFolder(Request $request)
    {
        $id = $request->id;

        DB::table('photos')->where('folder_id', $id)->delete();
        DB::table('folders')->where('id', $id)->delete();

        return redirect()->route('home');
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
            $photoName = Str::random(40) . ".png";
            $destinationPhotoPath = storage_path('/app/public/photos/client' . $user_id .'/' . $request->folder);
            $photo_path->move($destinationPhotoPath, $photoName);

            // Checkbox watermark
            if($request->watermark === "1"){
                $watermark = "yes";
            }else{
                $watermark = "no";
            };

            // Enregistrement des données dans la bdd
            $photo->photo_path =  $photoName;    
            $photo->user_id = $user_id;
            $photo->folder_id = $request->folder_id;
            $photo->watermark = $watermark;

            $photo->save(); // enregistrement

            if($watermark === "yes"){
                $withWatermark = Image::make($destinationPhotoPath . "/" . $photoName); // récupération de la photo
                $withWatermark->insert(storage_path('app/public/photos/client' . $user_id . '/watermark.png')); // ajout du watermark
                $withWatermark->save(); // enregistrement définitif
            };
        }

        return Redirect::back()->withSuccess('message', 'Photo enregistrée !');
    }

    // Supprimer une photo
    public function deletePhoto(Request $request)
    {
        foreach($request->id as $k => $v){
            $id = $request->id[$k];

            DB::table('photos')->where('id', explode(",",$id))->delete();
        }
        
        return Redirect::back();
    }
}
