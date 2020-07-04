<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function getByLesson(Request $request) {
        return response()->json([
            \App\Models\Lesson::where('id', $request->id)->questions()
        ]);
    }
}
