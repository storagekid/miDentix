import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';

import Scope from './modules/scope';
import User from './modules/user';
import Page from './modules/page';
import ShoppingCart from './modules/shopping-cart';
import Table from './modules/table';
import Form from './modules/form';
import Model from './modules/model';
import Modal from './modules/modal';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        Scope,
        User,
        Page,
        ShoppingCart,
        Table,
        Form,
        Model,
        Modal,
    },
    state: {
        app: {
        },
    },

    getters: {
        ready(state, getters,{Model, Form, Table, rootGetters}) {
            if (getters['Scope/ready']) {
                return true;
            }
            return false;
        }
    },

    actions: {
        // APP
        startApp({dispatch}) {
            dispatch('User/fetchUser');
        }
    },

    mutations: {
        //User
    }
})