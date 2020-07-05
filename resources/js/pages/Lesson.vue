<template>
    <div>
        <div v-if='!isLessonComplete'>
            <div v-for='question in questions' :key='question.id'>
                <div 
                    :class="question.is_active ? '' : 'hidden'"
                    class='text'
                >
                    {{ getRandomQuestion(question) }}
                    <br>
                    <input v-model="question.answer" class='text'>
                </div>
            </div>
            <div @click='nextQuestion()' class='text next-button'>
                Next
            </div>
        </div>

        <div v-if='isLessonComplete' class='text'>
            Complete
            <div class='correct'>
                {{ countOfMistakes == 0 ? '* * * * *' : '' }}
                {{ countOfMistakes == 1 ? '* * * *' : '' }}
                {{ countOfMistakes == 2 || countOfMistakes == 3 ? '* * *' : '' }}
                {{ countOfMistakes >= 4 && countOfMistakes <= 6 ? '* *' : '' }}
                {{ countOfMistakes >= 7 && countOfMistakes <= 9 ? '*' : '' }}
            </div>
            <div v-for='question in questions' :key='question.id' class='answer-check'>
                <div>
                    {{ JSON.parse(question.questions)[0] }}
                </div>
                <div :class="isAnswerRight(question) ? 'correct' : 'wrong'">
                    {{ question.answer === '' || question.answer === undefined ? '_____' : question.answer}}
                </div>
                <div v-if='!isAnswerRight(question)' class='correct'>
                    {{ JSON.parse(question.answers)[0]}}
                </div>
            </div>
        </div>
    </div>
</template>
    
<script>
import { getRandomInteger } from '../helpers/random.js';

export default {
    name: 'lesson',
    data() {
        return {
            questions: [],
            isLessonComplete: false,
            countOfMistakes: 0
        }
    },
    mounted() {
        axios.get(`/api/lesson?id=${this.$route.params.id}`).then(response => {
            this.questions = this.$store.getters.getQuestions(response.data.questions);
            this.questions[0].is_active = true;
        });
    },
    methods: {
        nextQuestion: function() {
            let questions = JSON.parse(JSON.stringify(this.questions));
            for (let i = 0; i < questions.length; i++) {
                if (questions[i].is_active) {
                    if (i < questions.length - 1) {
                        questions[i].is_active = false,
                        questions[i + 1].is_active = true;
                        break;
                    } else {
                        this.completeLesson();

                        break;
                    }
                }
            }
            this.questions = questions;
        },
        getRandomQuestion: function(question) {
            let questions = JSON.parse(question.questions)
            return questions[getRandomInteger(0, questions.length - 1)];
        },
        completeLesson() {
            this.isLessonComplete = true;
            this.countOfMistakes = this.getCountOfMistakes();
        },
        getCountOfMistakes() {
            let countOfMistakes = 0;
            for (let i = 0; i < this.questions.length; i++) {
                let rightAnswers = JSON.parse(this.questions[i].answers);
                let isAnswerRight = false;
                for (let j = 0; j < rightAnswers.length; j++) {
                    if (this.questions[i].answer == rightAnswers[j]) {
                        isAnswerRight = true;
                        break;
                    }
                }
                if (!isAnswerRight) {
                    countOfMistakes++;
                }
            }
            return countOfMistakes;
        },
        isAnswerRight(question) {
            let rightAnswers = JSON.parse(question.answers);
            let answer = question.answer;
            for (let i = 0; i < rightAnswers.length; i++) {
                if (answer == rightAnswers[i]) {
                    return true;
                }
            }
            return false;
        }
    }
}
</script>

<style scoped>
.hidden {
    display: none;
}
.next-button {
    margin-top: 40px;
}
.correct {
    color: green;
}
.wrong {
    color: red;
    text-decoration: line-through;
}
.answer-check {
    margin-top: 40px;
}
</style>