<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    public function get(Request $request)
    {
        return response()->json(
            \App\Models\Lesson::where('id', $request->id)->with('questions')->first()
        );
    }
}
