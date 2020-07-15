<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Lesson\LessonService;

class LessonsController extends Controller
{
    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function get(Request $request)
    {
        return response()->json(
            $this->lessonService->get($request)
        );
    }
}
