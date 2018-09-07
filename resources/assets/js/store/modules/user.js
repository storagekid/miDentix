const state = {
    user: {},
};
const getters = {};
const actions = {};
const mutations= {};

export default {
    namespaced: true,
    state,
    getters,
    actions : {
        fetchUser({state, commit, dispatch}) {
            axios.get('/api/user')
                .then(({data}) => {
                    commit('setUser', data);
                    dispatch('Scope/initScope', {profile: state.user.profile}, {root: true})
                })
        },
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
    }
}