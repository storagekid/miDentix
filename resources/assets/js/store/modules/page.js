const state = {
    pages: {},
};
const getters = {
    ready({pages}) {
        if (Object.keys(pages).length) {
            for (let page in pages) {
                if (!pages[page].ready) {
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
    setPage({pages}, payload) {
        Vue.set(pages, payload.name, {});
        Vue.set(pages[payload.name], 'ready', false);
        Vue.set(pages[payload.name], 'models', payload.models);
        Vue.set(pages[payload.name], 'tables', payload.tables);
    },
    setReady({pages}, payload) {
        pages[payload.name].ready = true;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}