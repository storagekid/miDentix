
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
Vue.component('schedule', require('./pages/schedule.vue'));
Vue.component('profile', require('./pages/profile.vue'));
Vue.component('requests', require('./pages/request.vue'));

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('main-menu', require('./components/main-menu.vue'));
Vue.component('clinics-table', require('./components/clinics/clinics-table.vue'));
Vue.component('schedule-pickup', require('./components/schedule/schedule-pickup.vue'));
Vue.component('masters', require('./components/profile/masters.vue'));
Vue.component('new-request', require('./components/requests/new-requests.vue'));

const app = new Vue({
    el: '#app'
});
