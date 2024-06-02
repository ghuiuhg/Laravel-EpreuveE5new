<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function showRatingsWithAverage()
    {
        $quizRatings = Rating::getQuizRatingsWithAverage();

        return view('afficheRating', ['quizRatings' => $quizRatings]);
    }

    public function showAllRatings(){
        $playerRatings = Rating::getAllRating();

        return view('afficheRating', ['playerRatings'=> $playerRatings]);
    }

}
