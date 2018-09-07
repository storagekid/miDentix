import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';

import Scope from './modules/scope';
import User from './modules/user';
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
        ShoppingCart,
        Table,
        Form,
        Model,
        Modal,
    },
    state: {
        app: {
        },
        pages: {},
    },

    getters: {
        ready(state, getters,{Model, Form, Table, rootGetters}) {
            if (!Model.ready || !Form.ready || !getters['Table/ready']) {
                return false;
            }
            return true;
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