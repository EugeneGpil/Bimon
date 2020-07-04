<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    public function getAll()
    {
        return response()->json(
            \App\Models\Subject::all()
        );
    }

    public function get(Request $request)
    {
        return response()->json(
            \App\Models\Subject::where('id', $request->id)->with('lessons')->first()
        );
    }
}
