import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store.js';

Vue.use(VueRouter);

export default new VueRouter({
	mode: "history",
	routes: [
		{
			path: '/',
			name: 'subjects',
			component: Vue.component('Market', require('./pages/Subjects.vue')).default,
		},
		{
			path: '/subject/:id',
			name: 'login',
			component: Vue.component('Login', require('./pages/Subject.vue')).default,
		},
		{
			path: '/lesson/:id',
			name: 'registration',
			component: Vue.component('Registration', require('./pages/Lesson.vue')).default,
		},
		// {
		// 	path: '/results',
		// 	name: 'basket',
		// 	component: Vue.component('Basket', require('./pages/Results.vue')).default,
		// }
	],
});
