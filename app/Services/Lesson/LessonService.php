<?php

namespace App\Services\Lesson;

use App\Services\Lesson\Repositories\LessonRepositoryInterface;

class LessonService
{
    protected $lessonRepositoryInterface;

    public function __construct(
        LessonRepositoryInterface $lessonRepositoryInterface
    ) {
        $this->lessonRepositoryInterface = $lessonRepositoryInterface;
    }

    public function get($request) {
        $lesson = $this->lessonRepositoryInterface->findById($request->id);

        $lessonsBefore = $this->lessonRepositoryInterface->getLessonsBefore(
            $request->id,
            $lesson->subject_id
        );

        $questionsBefore = [];

        foreach ($lessonsBefore as $beforelesson) {
            $questionsBefore = array_merge($questionsBefore, $beforelesson->questions->toArray());
        }

        $questionsBeforeWithoutMainQuestions = [];

        foreach ($questionsBefore as $beforeQuestion) {

            $isItMainQuestion = false;

            foreach ($lesson->questions as $mainQuestion) {

                if ($mainQuestion->id == $beforeQuestion['id']) {

                    $isItMainQuestion = true;
                    break;
                }
            }

            if (!$isItMainQuestion) {
                $questionsBeforeWithoutMainQuestions[] = $beforeQuestion;
            }
        }

        $selectedAdditonalQuestions = [];

        $mainQuestionsCount = count($lesson->questions);
        $questionsBeforeCount = count($questionsBeforeWithoutMainQuestions);
        for ($i = 0; $i < $mainQuestionsCount && $i < $questionsBeforeCount; $i++) {

            do {

                $randomAdditionalQuestion =
                    $questionsBeforeWithoutMainQuestions[array_rand(
                        $questionsBeforeWithoutMainQuestions
                    )];

                $isThisQuestionAlreadySelected = false;

                foreach ($selectedAdditonalQuestions as $selectedQuestion) {
                    if (
                        $selectedQuestion['id'] ==
                            $randomAdditionalQuestion['id']
                    ) {
                        $isThisQuestionAlreadySelected = true;
                        break;
                    }
                }
                
            } while ($isThisQuestionAlreadySelected);

            $selectedAdditonalQuestions[] = $randomAdditionalQuestion;
        }

        $lesson = $lesson->toArray();

        $lesson['questions'] = array_merge($lesson['questions'], $selectedAdditonalQuestions);

        shuffle($lesson['questions']);

        return $lesson;
    }
}