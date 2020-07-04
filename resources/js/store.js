import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import { questions } from './modules/questions.js';

export default new Vuex.Store({
	modules: {
        questions,
    }
});
