<?php

namespace App\Http\Controllers;

use App\Models\DisplayUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisplayUserController extends Controller
{
    public function GetPlayerParam()
    {
        $quizPlayer = DisplayUser::GetPlayer(); // Récupérer tous les joueurs

        return view('DisplayUser', compact('quizPlayer'));
    }

    public function updateProfilePhoto(Request $request, $id)
    {
        $request->validate([
            'photo_url' => 'required|url' // Valide que l'URL est bien formatée
        ]);
    
        // Récupérer l'URL de la photo depuis la requête
        $photoUrl = $request->input('photo_url');
    
        // Mettre à jour l'URL de la photo pour le joueur avec l'ID donné
        $affected = DB::table('Player')
                        ->where('Id', $id)
                        ->update(['PhotoProfil' => $photoUrl]);
    
        if ($affected) {
            return redirect()->back()->with('success', 'Profile photo updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update profile photo.');
        }
    }
    
    
    
}
