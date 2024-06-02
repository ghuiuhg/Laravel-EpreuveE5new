<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Rating extends Model
{
    public static function getQuizRatingsWithAverage()
    {
        $query = "
        SELECT 
            Quiz.Id, Quiz.[Content], Quiz.Description,
            AVG(QuizRating.rating) as average_rating
        FROM Quiz
        LEFT JOIN QuizRating ON Quiz.Id = QuizRating.QuizId
        GROUP BY Quiz.Id, Quiz.[Content], Quiz.Description;
        
        ";

        $quizRatings = DB::select($query);

        return $quizRatings;
    }


    public static function getAllRating(){
        $query = "
        SELECT
        Quiz.[Id] AS QuizId,
        Quiz.[Content] AS QuizContent,
        Player.[Name] AS PlayerName,
        QuizRating.rating
        FROM Quiz
        LEFT JOIN QuizRating ON Quiz.Id = QuizRating.QuizId
        LEFT JOIN Player ON QuizRating.PlayerId = Player.Id;
        ";

        $playerRatings = DB::select($query);

        return $playerRatings;
    }


}
