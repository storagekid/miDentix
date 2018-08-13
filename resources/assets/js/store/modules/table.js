import TableClass from '../../classes/tableClass';

const state = {
    tables: {},
};
const getters = {};
const actions = {
};
const mutations= {
    setTable(state, model) {
        Vue.set(state.tables, model, {});
        Vue.set(state.tables[model], 'ready', true);
    },
    removeTable(state, model) {
        Vue.delete(state.tables, model);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}