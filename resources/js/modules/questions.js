import { getRandomInteger } from '../helpers/random.js';

export const questions = {
    state: {
        getQuestions: (allQuestions) => {
            let mainQuestions = questions.state.getMainQuestions(allQuestions);
            let allSecondaryQuestions = questions.state.getAllSecondaryQuestions(allQuestions);
            let secondaryQuestions =
                questions.state.getRandomQuestions(allSecondaryQuestions, mainQuestions.length);
            return mainQuestions.concat(secondaryQuestions);
        },
        getMainQuestions: (allQuestions) => {
            let mainQuestions = [];
            for (let i = 0; i < allQuestions.length; i++) {
                let question = allQuestions[i];
                if (question.pivot.is_main) {
                    mainQuestions.push(question);
                }
            }
            return mainQuestions;
        },
        getAllSecondaryQuestions: (allQuestions) => {
            let mainQuestions = [];
            for (let i = 0; i < allQuestions.length; i++) {
                let question = allQuestions[i];
                if (!question.pivot.is_main) {
                    mainQuestions.push(question);
                }
            }
            return mainQuestions;
        },
        getRandomQuestions: (questions, amount) => {
            let randomQuestions = [];
            let numberOfAllQuestions = questions.length;
            
            for (let i = 0; i < amount && i < numberOfAllQuestions; i++) {

                let j;
                do {
                    j = getRandomInteger(0, numberOfAllQuestions - 1);
                } while (questions[j].used)

                questions[j].used = true;

                randomQuestions.push(questions[j]);
            }

            return randomQuestions;
        }
    },
    mutations: {
        // setUsername(state, username) {
        //     state.username = username;
        // }
    },
    actions: {
        // setUsername(context, username) {
        //     context.commit('setUsername', username);
        // }
    },
    getters: {
        // isObjectEmpty(state) {
        //     return state.isObjectEmpty;
        // }
        getQuestions(state) {
            return state.getQuestions;
        }
    }
}