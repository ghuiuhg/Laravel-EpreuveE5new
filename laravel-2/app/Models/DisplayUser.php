<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DisplayUser extends Model
{
    public static function GetPlayer()
    {
        $query = "SELECT Id, Name, PhotoProfil FROM Player";
        $quizPlayer = DB::select($query);
        return $quizPlayer;
    }
}