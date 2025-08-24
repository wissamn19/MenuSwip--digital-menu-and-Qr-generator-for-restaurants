<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function showForm()
    {
        return view('registration-owner');
    }

    public function register(Request $request)
    {
        //  ajoute validation et enregistrement en DB ici
        $data = $request->all();

        // Pour debug : tu peux tester avec dd($data);
        return redirect('/registration-owner')->with('success', 'Inscription réussie !');
    }
}