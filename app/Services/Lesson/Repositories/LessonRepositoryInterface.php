<?php

namespace App\Services\Lesson\Repositories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

interface LessonRepositoryInterface
{
    public function findById(int $id) :Lesson;
    public function getLessonsBefore(int $id, int $subjectId) :Collection;
}