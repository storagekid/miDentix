
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
Vue.component('page', require('./components/page.vue'));
Vue.component('custom-modal', require('./components/custom-modal.vue'));
Vue.component('shopping-cart-nav-container', require('./components/shopping-cart-nav-container.vue'));
Vue.component('shopping-cart', require('./components/shopping-cart.vue'));

// Vue.component('schedule', require('./pages/schedule.vue'));
Vue.component('profile', require('./pages/profile.vue'));
// Vue.component('requests', require('./pages/request.vue'));
// Vue.component('dentists', require('./pages/dentists.vue'));
// Vue.component('dentists2', require('./pages/dentists2.vue'));
// Vue.component('tutorial', require('./pages/tutorial.vue'));
// Vue.component('admin-dentists-control-panel', require('./pages/admin-dentists-control-panel.vue'));

Vue.component('vue-table', require('./components/table/vue-table.vue'));
// Vue.component('vue-table-row', require('./components/table/vue-table-row.vue'));
// Vue.component('vue-model-options', require('./components/vue-model-options'));
// Vue.component('filters', require('./components/filters.vue'));
Vue.component('profile-left', require('./components/profile/profile-left.vue'));
Vue.component('nav-left', require('./components/nav-left.vue'));
Vue.component('scope-menu', require('./components/scope-menu.vue'));
Vue.component('main-menu', require('./components/main-menu.vue'));
// Vue.component('clinics-table', require('./components/clinics/clinics-table.vue'));
// Vue.component('schedule-pickup', require('./components/schedule/schedule-pickup.vue'));
// Vue.component('masters', require('./components/profile/masters.vue'));
Vue.component('pass-changer', require('./components/profile/pass-changer.vue'));
Vue.component('profile-form', require('./components/profile/profile-form.vue'));
// Vue.component('new-request', require('./components/requests/new-requests.vue'));
// Vue.component('extra-time', require('./components/schedule/extra-time.vue'));
// Vue.component('stationary', require('./components/stationary/index.vue'));
// Vue.component('providers', require('./components/providers/index.vue'));


import store from './store';

import router from './routes';

import VModal from 'vue-js-modal';
Vue.use(VModal);

import Helpers from './tools/helpers';
Vue.use(Helpers);

const app = new Vue({
    el: '#app',
    store,
    router,
    data: {
        leftMenu: true,
    },
    watch: {
        modalsToShow() {
            for (let modal of this.modalsToShow) {
                this.$modal.show(modal);                    
            }               
        },
        modalsToHide() {
            for (let modal of this.modalsToHide) {
                this.$modal.hide(modal);
            }
        },
    },
    computed: {
        mainColumns() {
            if (this.leftMenu) {
                return 'col-sm-10';
            } else {
                return 'col-sm-12';
            }
        },
        modalsToShow() {
            let modals = [];
            for (let modal in this.$store.state.Modal.modals) {
                if (this.$store.state.Modal.modals[modal].active) modals.push(modal);
            }
            return modals;
        },
        modalsToHide() {
            let modals = [];
            for (let modal in this.$store.state.Modal.modals) {
                if (!this.$store.state.Modal.modals[modal].active) modals.push(modal);
            }
            return modals;
        }
    },
    methods: {
        toggleMainColumns($event) {
            this.leftMenu = $event.data;
        }
    },
    created() {
        this.$store.dispatch('startApp');
        // this.$store.dispatch('fetchUser');
        window.events.$on('toggleLeftMenu', this.toggleMainColumns);
    },
});
