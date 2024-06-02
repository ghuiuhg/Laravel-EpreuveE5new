<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatModel;

class StatModelController extends Controller
{
    public function GetCountStats(){
        $quizCount = StatModel::GetQuizCount();
        $questionCount = StatModel::GetQuestionCount();

        return view('AfficheStat', [
            'quizCount' => $quizCount,
            'questionCount' => $questionCount,
        ]);
    }
}
