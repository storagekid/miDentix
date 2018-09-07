import TableClass from '../../classes/tableClass';

const state = {
    tables: {},
};
const getters = {
    ready({tables}) {
        if (Object.keys(tables).length) {
            for (let table in tables) {
                if (!tables[table].ready) {
                    return false;
                }
            }
        } else {
            return true;
        }
        return true;
    }
};
const actions = {
};
const mutations= {
    setTable(state, model) {
        Vue.set(state.tables, model, {});
        Vue.set(state.tables[model], 'ready', false);
    },
    removeTable(state, model) {
        Vue.delete(state.tables, model);
    },
    setReady(state, model) {
        console.log('Setting Ready ' + model);
        console.log('Tables: ' + state.tables);
        state.tables[model].ready = true;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}