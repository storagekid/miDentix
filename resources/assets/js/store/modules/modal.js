const state = {
    modals: {},
};
const getters = {};
const actions = {
};
const mutations= {
    newModal(state, {name, data}) {
        Vue.set(state.modals, name, data);
        Vue.set(state.modals[name], 'active', true);
    },
    hideModal(state,{name}) {
        state.modals[name].active = false;
    },
    destroyModal(state,{name}) {
        Vue.delete(state.modals, name);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}