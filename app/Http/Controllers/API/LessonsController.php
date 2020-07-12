<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonsController extends Controller
{
    public function get(Request $request)
    {
        return response()->json(
            Lesson::where('id', $request->id)->with('questions')->first()
        );
    }
}
