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
                    <input v-model="question.answer" class='text'
                        v-on:keyup.enter='nextQuestion()'
                        :ref='`ref${question.id}`'
                        :type='question.input_type'
                    >
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
            <div @click='restartLesson()' class='next-button'>
                Again
            </div>
            <router-link to='/' class='next-button'>
                Home
            </router-link>
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
            countOfMistakes: 0,
        }
    },
    mounted() {
        axios.get(`/api/lesson?id=${this.$route.params.id}`).then(response => {
            // this.questions = this.$store.getters.getQuestions(response.data.questions);
            this.questions = response.data.questions;
            this.questions[0].is_active = true;
        });
    },
    created() {
        setTimeout(() => {
            this.$nextTick(() => this.setFocus(`ref${this.questions[0].id}`));
        }, 1000);
    },
    methods: {
        nextQuestion: function() {
            let questions = JSON.parse(JSON.stringify(this.questions));
            for (let i = 0; i < questions.length; i++) {
                if (questions[i].is_active) {
                    if (i < questions.length - 1) {
                        questions[i].is_active = false,
                        questions[i + 1].is_active = true;
                        this.setFocus(`ref${questions[i + 1].id}`);
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
        },
        setFocus(ref) {
            setTimeout(() => {
                this.$refs[ref][0].focus();
            }, 200);
        },
        restartLesson() {
            let questions = JSON.parse(JSON.stringify(this.questions));
            for (let i = 0; i < questions.length; i++) {
                questions[i].is_active = false;
                questions[i].answer = undefined;
            }
            questions[0].is_active = true;
            this.isLessonComplete = false;
            this.questions = questions;
            this.setFocus(`ref${questions[0].id}`);
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
    display: block;
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