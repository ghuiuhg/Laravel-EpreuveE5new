<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\SUpport\Facades\DB;



class FichierController extends Controller
{

        function Upload(){
            return view("fichierView");
        }



        function UploadPost(Request $request)
        {
            if ($request->hasFile('file')) {
                $file = $request->file("file");
                $path = $file->storeAs('uploads', $file->getClientOriginalName());
    
                $quizData = [];
    
                if (($handle = fopen(storage_path('app/' . $path), 'r')) !== FALSE) {
                    while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $data = str_getcsv($row[0], ';');
    
                        if (count($data) >= 5) {
                            $questionContent = $data[0];
                            $description = $data[1];
                            $difficultyLabel = $data[2];
                            $bonnesReponses = explode(';', trim($data[3], '" '));
                            $mauvaisesReponses = explode(';', trim($data[4], '" '));
    
                            // Insérer la difficulté dans la table 'difficulties'
                            $difficulty = DB::table('Difficulty')->where('label', $difficultyLabel)->first();
                            if (!$difficulty) {
                                $difficulty = DB::table('x²S')->insertGetId(['label' => $difficultyLabel]);
                            }
    
                            // Insérer la question dans la table 'questions'
                            $question = DB::table('questions')->insertGetId([
                                'content' => $questionContent,
                                'description' => $description,
                                'difficulty_id' => $difficulty->id,
                            ]);
    
                            // Insérer les réponses dans la table 'answers' et 'question_answers'
                            foreach ($bonnesReponses as $bonneReponse) {
                                $answer = DB::table('answers')->firstOr(['content' => $bonneReponse]);
                                if (!$answer) {
                                    $answer = DB::table('answers')->insertGetId(['content' => $bonneReponse]);
                                }
    
                                DB::table('question_answers')->insert([
                                    'question_id' => $question,
                                    'answer_id' => $answer->id,
                                    'correct' => 1, // 1 pour vraie réponse
                                ]);
                            }
    
                            foreach ($mauvaisesReponses as $mauvaiseReponse) {
                                $answer = DB::table('answers')->firstOr(['content' => $mauvaiseReponse]);
                                if (!$answer) {
                                    $answer = DB::table('answers')->insertGetId(['content' => $mauvaiseReponse]);
                                }
    
                                DB::table('question_answers')->insert([
                                    'question_id' => $question,
                                    'answer_id' => $answer->id,
                                    'correct' => 0, // 0 pour fausse réponse
                                ]);
                            }
                        }
                    }
                    fclose($handle);
    
                    Storage::delete($path);
    
                    echo "Données insérées avec succès dans la base de données.";
                } else {
                    // Gérer les erreurs liées à l'ouverture du fichier CSV.
                    echo "Erreur lors de l'ouverture du fichier CSV.";
                }
            } else {
                return "Aucun fichier n'a été téléchargé.";
            }
        }
    }
        

    //     public function insertDataIntoDatabase($quizData)
    //     {
    //     foreach ($quizData as $quiz) {
    //         $questionId = DB::table('Question')->insertGetId([
    //             'Content' => $quiz['Question'],
    //             'Description' => $quiz['Description'],
    //             'DifficultyId' => DB::table('Difficulty')->where('Label', $quiz['Difficulte'])->value('Id'),
    //         ]);

    //         $bonnesReponses = explode(';', $quiz['BonnesReponses']);
    //         $mauvaisesReponses = explode(';', $quiz['MauvaisesReponses']);

    //         foreach ($bonnesReponses as $reponse) {
    //             $answerId = DB::table('Answer')->insertGetId([
    //                 'Content' => $reponse,
 
    //             ]);

    //             DB::table('QuestionAnswer')->insert([
    //                 'QuestionId' => $questionId,
    //                 'AnswerId' => $answerId,
    //                 'Correct' => 1, // Réponse correcte (bit = 1)
    //             ]);
    //         }

    //         foreach ($mauvaisesReponses as $reponse) {
    //             $answerId = DB::table('Answer')->insertGetId([
    //                 'Content' => $reponse,
    //                 'Description' => 'Description de la réponse', // Remplacez par la description appropriée
    //             ]);

    //             DB::table('QuestionAnswer')->insert([
    //                 'QuestionId' => $questionId,
    //                 'AnswerId' => $answerId,
    //                 'Correct' => 0, // Réponse incorrecte (bit = 0)
    //             ]);}
    //     }
    // }




        
        
        
    
    
    



