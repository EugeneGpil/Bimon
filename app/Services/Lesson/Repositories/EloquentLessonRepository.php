<?php

namespace App\Services\Lesson\Repositories;

use App\Models\Lesson;
use App\Services\Lesson\Repositories\LessonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentLessonRepository implements LessonRepositoryInterface
{
    public function findById(int $id) :Lesson
    {
        return Lesson::where('id', $id)->with('questions')->first();
    }

    public function getLessonsBefore(int $id, int $subjectId) :Collection
    {
        return Lesson::where('id', '<', $id)
            ->where('subject_id', $subjectId)->with('questions')->get();
    }
}