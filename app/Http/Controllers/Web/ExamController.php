<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Controllers\Controller;

class ExamController extends Controller
{
    public function start()
    {
        $questions = Question::all(); // Fetch all questions
        return view('exam.start', compact('questions'));
    }

    public function submit(Request $request)
    {
        $score = 0;
        $total = count($request->answers ?? []);

        foreach ($request->answers as $id => $answer) {
            $question = Question::find($id);
            if ($question && $question->correct_option === $answer) {
                $score++;
            }
        }

        return view('exam.result', compact('score', 'total'));
    }
}
