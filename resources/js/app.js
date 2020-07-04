require('./bootstrap');

import Vue    	 from 'vue';
import router    from './routes.js';
import store from './store.js';

const app = new Vue({
    el: '#app',
    router,
    store,
});

Vue.config.productionTip = false; // TODO remove
