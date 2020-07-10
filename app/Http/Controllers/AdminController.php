<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use App\User;

class AdminController extends Controller
{
    public function createUser(Request $request)
    {
        // Règles
        $rules = [
            'name' => "string|required",
            'role' => "string|required",
            'email' => 'email|required',
        ];

        // Messages d'erreur
        $validator = Validator::make($request->all(), [// Mise en place des messages d'erreurs liés au champs correspondants (en fonction des règles établies ci-dessus)
            'name.string' => 'Le nom de l\'utilisateur.trice ne doit pas comporter de caractères spéciaux',
            'name.required' => 'Le nom de l\'utilisateur.trice est obligatoire',
            'email.email' => 'L\'adresse mail n\'est pas correcte',
            'email.required' => 'L\'adresse mail de l\'utilisateur.trice est obligatoire',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        };

        // Création de l'entrée en bdd
        $user = new User;

        if($request->role = 1){
            $role = 'administrateur';
        }else{
            $role = 'client';
        };

        $user->name = $request->name;
        $user->role = $role;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return Redirect::back()->with('success', 'Utilisateur.trice enregistré.e !');

    }
    
    public function editUserForm(Request $request)
    {
        $id = $request->id;
        $users = User::where('id', $id)->get();

        return view('admin.edit')->with('users', $users);

    }

    public function editUser(Request $request)
    {
        // Règles
        $rules = [
            'name' => "string|required",
            'role' => "string|required",
            'email' => 'email|required',
        ];

        // Messages d'erreur
        $validator = Validator::make($request->all(), [// Mise en place des messages d'erreurs liés au champs correspondants (en fonction des règles établies ci-dessus)
            'name.string' => 'Le nom de l\'utilisateur.trice ne doit pas comporter de caractères spéciaux',
            'name.required' => 'Le nom de l\'utilisateur.trice est obligatoire',
            'email.email' => 'L\'adresse mail n\'est pas correcte',
            'email.required' => 'L\'adresse mail de l\'utilisateur.trice est obligatoire',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        };

        if($request->role === "1" ){
            $role = 'administrateur';
        }else{
            $role = 'client'; 
        }

        $user = User::where('id', $request->id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "role" => $role,
        ]);

        return redirect()->route('home');
    }

    public function deleteUser(Request $request)
    {
        $id = $request->id;

        DB::table('photos')->where('user_id', $id)->delete();
        DB::table('folders')->where('user_id', $id)->delete();
        DB::table('users')->where('id', $id)->delete();

        return redirect()->back();
    }

}
