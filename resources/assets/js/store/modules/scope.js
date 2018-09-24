const state = {
    clinics: {
        ids: [],
        selected: null,
    },
    counties: {
        ids: [],
        selected: null,
    },
    states: {
        ids: [],
        selected: null,
    },
    countries: {
        ids: [],
        selected: null,
    },
    language: 'ES-es',
    scopeKey: '',
};
const getters = {
    ready(state, getters, rootState) {
        if (rootState.Model.models.countries && rootState.Model.models.counties && rootState.Model.models.states && rootState.Model.models.clinics) {
            if (rootState.Model.models.countries.items && rootState.Model.models.counties.items && rootState.Model.models.states.items && rootState.Model.models.clinics.items) {
                return true;
            }
        }
        return false;
    },
    key(state) {
        let country = state.countries.selected ? state.countries.selected : '-';
        let county = state.counties.selected ? state.counties.selected : '-';
        let stateID = state.states.selected ? state.states.selected : '-';
        let clinic = state.clinics.selected ? state.clinics.selected : '-';
        return country + '.' + stateID + '.' + county + '.' + clinic;
    }
};
const actions = {
    initScope({state, commit, dispatch, rootState}, {profile}) {
        commit('setCountries', profile.countryIdsScope);
        commit('setCounties', profile.countyIdsScope);
        commit('setStates', profile.stateIdsScope);
        commit('setClinics', profile.clinicIdsScope);
        if (window.$cookies.isKey(rootState.User.user.email + '-scope')) {
            let scopeArray = window.$cookies.get(rootState.User.user.email + '-scope').split('.');
            commit('selectScopeModel', {model: 'countries', id: scopeArray[0]});
            commit('selectScopeModel', {model: 'states', id: scopeArray[1]});
            commit('selectScopeModel', {model: 'counties', id: scopeArray[2]});
            commit('selectScopeModel', {model: 'clinics', id: scopeArray[3]});
        } else if (state.countries.ids.length == 1) {
            commit('selectScopeModel', {model: 'countries', id: state.countries.ids[0]});
            if (state.states.ids.length == 1) {
                commit('selectScopeModel', {model: 'states', id: state.states.ids[0]});
                if (state.counties.ids.length == 1) {
                    commit('selectScopeModel', {model: 'counties', id: state.counties.ids[0]});
                    if (state.clinics.ids.length == 1) {
                        commit('selectScopeModel', {model: 'clinics', id: state.clinics.ids[0]});
                    }
                }
            }
        }

        commit('setScopeKey');
        dispatch('Model/fetchFilteredModels', {models: {'clinics':{ids:null}}}, {root: true});
        dispatch('Model/fetchFilteredModels', {models: {'countries':{ids:null}}}, {root: true});
        dispatch('Model/fetchFilteredModels', {models: {'counties':{ids:null}}}, {root: true});
        dispatch('Model/fetchFilteredModels', {models: {'states':{ids:null}}}, {root: true});
    }
};
const mutations = {
    setScopeKey(state) {
        let country = state.countries.selected ? state.countries.selected : '-';
        let county = state.counties.selected ? state.counties.selected : '-';
        let stateID = state.states.selected ? state.states.selected : '-';
        let clinic = state.clinics.selected ? state.clinics.selected : '-';
        console.log('Setting Scope Key: ' + country+stateID+county+clinic);
        state.scopeKey = country + '.' + stateID + '.' + county + '.' + clinic;
    },
    setCountries(state, ids) {
        state.countries.ids = ids;
    },
    setCounties(state, ids) {
        state.counties.ids = ids;
    },
    setStates(state, ids) {
        state.states.ids = ids;
    },
    setClinics(state, ids) {
        state.clinics.ids = ids;
    },
    addCountry(state, id) {
        if (!state.countries.ids.includes(id)) {
            state.countries.ids.push(id);
        }
    },
    addCounty(state, id) {
        if (!state.counties.ids.includes(id)) {
            state.counties.ids.push(id);
        }
    },
    addState(state, id) {
        if (!state.states.ids.includes(id)) {
            state.states.ids.push(id);
        }
    },
    addClinic(state, id) {
        if (!state.clinics.ids.includes(id)) {
            state.clinics.ids.push(id);
        }
    },
    selectScopeModel(state, {model, id}) {
        state[model].selected = id;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
}