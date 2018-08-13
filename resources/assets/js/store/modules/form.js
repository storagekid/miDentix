const state = {
    forms: {},
    ready: true,
};
const getters = {};
const actions = {
};
const mutations= {
    setForm(state, {model, models, relations}) {
        Vue.set(state.forms, model, {});
        Vue.set(state.forms[model], 'ready', true);
        Vue.set(state.forms[model], 'relations', relations);
        Vue.set(state.forms[model], 'modelsNeeded', models);
    },
    destroyForm({forms}, {name}) {
        Vue.delete(forms, name);            
    },
    formsNotReady(state) {
        state.ready = false;
    },
    formsReady(state) {
        state.ready = true;
    },
    newRelationForm(state, {model, relation}) {
        Vue.set(state.forms[model]['relations'][relation], 'active', true);
    },
    hideRelationForm(state, {model, relation}) {
        state.forms[model]['relations'][relation].active = false;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}