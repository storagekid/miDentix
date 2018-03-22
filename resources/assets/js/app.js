
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

import Vuex from 'vuex';
Vue.use(Vuex);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('counter', require('./components/Counter.vue'));

Vue.component('loading', require('./components/loading.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('page', require('./components/page.vue'));

Vue.component('schedule', require('./pages/schedule.vue'));
Vue.component('profile', require('./pages/profile.vue'));
Vue.component('requests', require('./pages/request.vue'));
Vue.component('dentists', require('./pages/dentists.vue'));
Vue.component('dentists2', require('./pages/dentists2.vue'));
Vue.component('tutorial', require('./pages/tutorial.vue'));
Vue.component('admin-dentists-control-panel', require('./pages/admin-dentists-control-panel.vue'));

Vue.component('vue-table', require('./components/vue-table.vue'));
Vue.component('vue-model-options', require('./components/vue-model-options'));
Vue.component('filters', require('./components/filters.vue'));
Vue.component('profile-left', require('./components/profile/profile-left.vue'));
Vue.component('nav-left', require('./components/nav-left.vue'));
Vue.component('main-menu', require('./components/main-menu.vue'));
Vue.component('clinics-table', require('./components/clinics/clinics-table.vue'));
Vue.component('schedule-pickup', require('./components/schedule/schedule-pickup.vue'));
Vue.component('masters', require('./components/profile/masters.vue'));
Vue.component('pass-changer', require('./components/profile/pass-changer.vue'));
Vue.component('profile-form', require('./components/profile/profile-form.vue'));
Vue.component('new-request', require('./components/requests/new-requests.vue'));
Vue.component('extra-time', require('./components/schedule/extra-time.vue'));
Vue.component('clinics', require('./components/clinics/clinics.vue'));

const shared = {
    role: App.role,
    group: App.group,
    page: App.page,
}
shared.install = function(){
  Object.defineProperty(Vue.prototype, '$global', {
    get () { return shared }
  })
}
Vue.use(shared);
const app = new Vue({
    el: '#app',
    data: {
        ready: false,
        leftMenu: true,
    },
    computed: {
        mainColumns() {
            if (this.leftMenu) {
                return 'col-sm-10';
            } else {
                return 'col-sm-12';
            }
        }
    },
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
    	},
        toggleMainColumns($event) {
            this.leftMenu = $event.data;
        }
    },
    created() {
    	setInterval(this.checkSession, (6*60*1000));
        window.events.$on('toggleLeftMenu', this.toggleMainColumns);
    },
});
