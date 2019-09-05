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
                    // let params = {
                    //     'grant_type' : 'password',
                    //     'client_id' : 1,
                    //     'client_secret' : 'HdS6IRVRqfVlRKVF0OnRtTXSlYTAfUK3pRRJFMw4',
                    //     'username' : 'dhernandez@dentix.es',
                    //     'password' : 'Migabinete01',
                    //     'scope' : '',
                    // }
                    // axios.post('/oauth/token', {
                    //     'params': params,
                    // })
                    // .then((data) => {
                    //     console.log(data);
                    // }) ;
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