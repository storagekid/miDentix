import Vuex from 'vuex';
import Vue from 'vue';
import axios from 'axios';

import ShoppingCart from './modules/shopping-cart';
import Table from './modules/table';
import Form from './modules/form';
import Model from './modules/model';
import Modal from './modules/modal';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        ShoppingCart,
        Table,
        Form,
        Model,
        Modal
    },
    state: {
        user: {},
        app: {
        },
        pages: {},
    },

    getters: {
        ready({readiness, Model, Form}) {
            if (!Model.ready || !Form.ready) {
                return false;
            }
            return true;
        }
    },

    actions: {
        // USER
        fetchUser({commit}) {
            axios.get('/api/user')
                .then(({data}) => {
                    commit('setUser', data);
                })
        },
    },

    mutations: {
        //User
        setUser(state, user) {
            state.user = user;
        },
    }
})