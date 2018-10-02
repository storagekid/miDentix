
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

import store from './store';

import router from './routes';

import VModal from 'vue-js-modal';
Vue.use(VModal);

import Helpers from './tools/helpers';
Vue.use(Helpers);

import VueCookies from 'vue-cookies';
Vue.use(VueCookies);

import { library } from '@fortawesome/fontawesome-svg-core';
import { faClone, faEye, faEdit, faTrashAlt } from '@fortawesome/free-regular-svg-icons';
import { faMinus } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faClone, faEye, faTrashAlt, faEdit);
library.add(faMinus);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('loading', require('./components/loading.vue'));
Vue.component('flash', require('./components/Flash.vue'));
Vue.component('page', require('./components/page.vue'));
Vue.component('page-loading', require('./components/page-loading.vue'));
Vue.component('custom-modal', require('./components/custom-modal.vue'));
Vue.component('shopping-cart-nav-container', require('./components/shopping-cart-nav-container.vue'));
Vue.component('shopping-cart', require('./components/shopping-cart.vue'));

Vue.component('vue-table', require('./components/table/vue-table.vue'));

Vue.component('profile-left', require('./components/profile/profile-left.vue'));
Vue.component('nav-left', require('./components/nav-left.vue'));
Vue.component('scope-menu', require('./components/scope-menu.vue'));
Vue.component('main-menu', require('./components/main-menu.vue'));

Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.config.productionTip = false;

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
        ready() {
            return this.$store.getters.ready;
        },
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
        // this.$store.dispatch('runCounter');
        // this.$store.dispatch('fetchUser');
        window.events.$on('toggleLeftMenu', this.toggleMainColumns);
    },
});
