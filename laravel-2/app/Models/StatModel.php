<?php

// app/Models/StatModel.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StatModel extends Model
{
    public static function GetQuizCount()
    {
        $query = "SELECT COUNT(*) AS NumberOfQuizzes
        FROM Quiz";
        $quizCount = DB::select($query);
        return $quizCount;
    }

    public static function GetQuestionCount()
    {
        $query = "SELECT COUNT(*) AS NumberOfQuestions
        FROM Question";
        $questionCount = DB::select($query);
        return $questionCount;
    }   
}

