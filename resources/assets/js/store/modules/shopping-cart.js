const state = {
    shoppingCart: [],
};
const getters = {};
const actions = {};
const mutations= {};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations: {
        shoppingCartToggle(state, {item}) {
            if (state.shoppingCart.includes(item)) {
              state.shoppingCart.splice(state.shoppingCart.indexOf(item),1);
            } else {
              state.shoppingCart.push(item);
            }
        },
        cleanShoppingCart(state) {
            state.shoppingCart = [];
        }
    }
}