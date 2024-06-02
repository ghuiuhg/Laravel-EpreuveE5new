<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DisplayUser;

class ProfileController extends Controller
{
    public function update(Request $request, $id)
    {
        // Validation : Vérifie que 'profile_image' est une URL valide
        $request->validate([
            'profile_image' => 'url',
        ]);

        // Mise à jour de la base de données : Modifie la colonne 'PhotoProfil' dans la table 'Player' pour l'utilisateur avec l'ID donné
        DB::update("UPDATE Player SET PhotoProfil = ? WHERE Id = ?", [
            $request->input('profile_image'), // Nouvelle URL de la photo de profil
            $id, // ID de l'utilisateur à mettre à jour
        ]);

        // Redirection : Retourne à la page précédente
        return redirect()->back();
    }
}
