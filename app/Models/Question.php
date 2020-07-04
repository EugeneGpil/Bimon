<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function getAnswers()
    {
        return json_decode($this->answers, true);
    }

    public function getQuestions()
    {
        return json_decode($this->questions, true);
    }
}
