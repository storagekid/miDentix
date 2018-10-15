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
    setTable(state, {model}) {
        Vue.set(state.tables, model, {});
        Vue.set(state.tables[model], 'ready', false);
        Vue.set(state.tables[model], 'filtered', []);
        console.log('Table ' + model + ' setted');
    },
    removeTable(state, model) {
        Vue.delete(state.tables, model);
    },
    setReady(state, {model}) {
        // console.log('Setting Ready ' + model);
        // console.log('Tables: ' + state.tables);
        state.tables[model].ready = true;
        console.log('Table ' + model + ' Ready');
    },
    selectRow(state, {table, id}) {
        console.log(table);
        state.tables[table].selected.push(id);
    }
 };

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}