<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        foreach($request->file('photo') as $stored){
            $user_id = Auth::user()->id;

            // Restriction de taille et d'extension des photos
            $rules = [
                'photo' => 'required|mimes:jpeg,png,jpg,gif,pdf|max:2048'
            ];

            // Mise en place des messages d'erreur
            $validator = Validator::make($request->all(), [
                'photo.required' => 'Veuillez attacher une photo',
                'photo.mimes' =>'L\'extension du fichier est incorrecte',
                'photo.max' =>'La taille du fichier est trop importante',
            ]);

            if($validator->fails()){
                return Redirect::back()->withErrors($validator)->withInputs();
            }
            
            // Création de l'entrée en bdd
            $photo = new Photo;

            // Enregistrement de la photo en local
            $photoName = Str::random(40) . ".png";
            $destinationPhotoPath = storage_path('/app/public/photos/Client' . $user_id . '/' . $request->folder);
            $stored->move($destinationPhotoPath, $photoName);

            // Resize de la photo pour qu'elle ne soit pas trop lourde
            $resized = Image::make(public_path('storage/photos/Client' . $user_id . '/' . $request->folder . '/' .$photoName))
                    ->resize(1000, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
            $resized->save();

            // Checkbox watermark
            if($request->watermark === "1"){
                $watermark = "yes";
            }else{
                $watermark = "no";
            };

            // Enregistrement des données dans la bdd
            $photo->photo =  $photoName;    
            $photo->user_id = $user_id;
            $photo->folder_id = $request->folder_id;
            $photo->watermark = $watermark;

            $photo->save(); // enregistrement

            if($watermark === "yes"){
                $wtm = Image::make(public_path('storage/photos/Client' . $user_id .'/watermark.png'));
                $wtmwidth = $wtm->width();
                $wtmheight = $wtm->height();

                $withWatermark = Image::make($destinationPhotoPath . "/" . $photoName); // récupération de la photo
                $photowidth = $withWatermark->width();
                $photoheight = $withWatermark->height();

                $x = 0;
                $y = 0;

                while($y<=$photoheight){
                    $withWatermark->insert(storage_path('app/public/photos/Client' . $user_id . '/watermark.png'), 'top-left', $x, $y); // ajout du watermark
                    $x+=$wtmwidth;
                    if($x>=$photowidth){
                        $x=0;
                        $y+=$wtmheight;
                    }
                }
                $withWatermark->save(); // enregistrement définitif
            };
        }

        return Redirect::back()->withSuccess('message', 'Photo enregistrée !');
    }

    // Afficher une photo
    public function showPhoto(Request $request)
    {
        $folder_id = $request->folder_id;
        $photo_id = $request->photo_id;
        $folders = Folder::where('id', $folder_id)->get();
        $photos = Photo::where('id', $photo_id)->get();

        return view('singlephoto')->with('folders', $folders)->with('photos', $photos);
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
