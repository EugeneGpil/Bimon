import { getRandomInteger } from '../helpers/random.js';

export const questions = {
    state: {
        getQuestions: (allQuestions) => {
            let mainQuestions = questions.state.getMainQuestions(allQuestions);
            let allSecondaryQuestions = questions.state.getAllSecondaryQuestions(allQuestions);
            let secondaryQuestions =
                questions.state.getRandomQuestions(allSecondaryQuestions, mainQuestions.length);
            let selectedQuestions = mainQuestions.concat(secondaryQuestions);
            let mixedQuestions = questions.state.getShuffledArray(selectedQuestions);
            return mixedQuestions;
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
        },
        getShuffledArray(array) {
            let arrayToReturn = JSON.parse(JSON.stringify(array));
            for (let i = arrayToReturn.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [arrayToReturn[i], arrayToReturn[j]] = [arrayToReturn[j], arrayToReturn[i]];
            }
            return arrayToReturn;
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