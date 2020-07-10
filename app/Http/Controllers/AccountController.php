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

class AccountController extends Controller
{
    public function index(Request $request){
        $users_id = $request->id;
        $users = DB::table('users')->where('id', $users_id)->get();

        return view('account')->with('users', $users);
    }

    public function edit(Request $request)
    {
        // Règles
        $rules = [
            'name' => "string|required",
            'email' => 'email|required',
            'watermark' => 'mimes:png|max:1080'
        ];

        // Messages d'erreur
        $validator = Validator::make($request->all(), [// Mise en place des messages d'erreurs liés au champs correspondants (en fonction des règles établies ci-dessus)
            'name.string' => 'Le nom de l\'utilisateur.trice ne doit pas comporter de caractères spéciaux',
            'name.required' => 'Le nom de l\'utilisateur.trice est obligatoire',
            'email.email' => 'L\'adresse mail n\'est pas correcte',
            'email.required' => 'L\'adresse mail de l\'utilisateur.trice est obligatoire',
            'photo_path.mimes' =>'L\'extension du fichier est incorrecte, choississez un fichier en .png',
            'photo_path.max' =>'La taille du fichier est trop importante',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        };

        if($_FILES["watermark"]["error"] == 0){
            $watermark = $request->file('watermark');
            // Enregistrement de la photo en local
            $user_id = Auth::user()->id;
            $watermarkName = "watermark.png";
            $watermark->storeAs('public/photos/client' . $user_id, $watermarkName);
        }else{
            $watermarkName = "NULL";
        }


        $user = User::where('id', $request->id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "watermark" => $watermarkName,
        ]);

        return Redirect::back()->with('success', 'Modification(s) enregistrée(s)');
    }
}
