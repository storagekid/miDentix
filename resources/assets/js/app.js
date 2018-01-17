
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.events = new Vue();

window.flash = function (message) {
	window.events.$emit('flash', message);
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('loading', require('./components/loading.vue'));
Vue.component('flash', require('./components/Flash.vue'));

Vue.component('schedule', require('./pages/schedule.vue'));
Vue.component('profile', require('./pages/profile.vue'));
Vue.component('requests', require('./pages/request.vue'));
Vue.component('users', require('./pages/users.vue'));
Vue.component('tutorial', require('./pages/tutorial.vue'));
Vue.component('admin-control-panel', require('./pages/admin-control-panel.vue'));

Vue.component('filters', require('./components/filters.vue'));
Vue.component('main-menu', require('./components/main-menu.vue'));
Vue.component('clinics-table', require('./components/clinics/clinics-table.vue'));
Vue.component('schedule-pickup', require('./components/schedule/schedule-pickup.vue'));
Vue.component('masters', require('./components/profile/masters.vue'));
Vue.component('pass-changer', require('./components/profile/pass-changer.vue'));
Vue.component('profile-form', require('./components/profile/profile-form.vue'));
Vue.component('new-request', require('./components/requests/new-requests.vue'));
Vue.component('extra-time', require('./components/schedule/extra-time.vue'));

const app = new Vue({
    el: '#app',
    methods: {
    	checkSession() {
    		axios.get('/api/session')
    			.catch(response => {
    				console.log(response);
    				window.location.href = '/login';
    			})
    			.then(data => {
    				console.log(data.status);
    				if (data.status != 200) {
    					window.location.href = '/logout';
    				}
    			});
    	}
    },
    created() {
    	setInterval(this.checkSession, (6*60*1000));
    },
});
