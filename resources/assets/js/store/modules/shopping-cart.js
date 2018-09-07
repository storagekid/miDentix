import ShoppingCartCategory from '../../classes/shoppingCartCategoryClass';

const state = {
    shoppingCart: {},
};
const getters = {
    itemsInCart({shoppingCart}) {
        let qty = 0;
        for (let model in shoppingCart) {
            qty += shoppingCart[model].ids.length;
        }
        return qty;
    },
};
const actions = {};
const mutations= {};

export default {
    namespaced: true,
    state,
    getters,
    actions : {
        setOrder({state, commit, rootState}, {clinic, e, classes}) {
            axios.post('/order/'+clinic, {items: state.shoppingCart})
                .then(({data}) => {
                    commit('cleanShoppingCart', {categories: null});
                    if (rootState.Model.models.orders) {
                        for (let order of data.newmodel) {
                            commit('Model/addNewModel', {modelName: 'orders', model: order}, {root: true});
                            // setTimeout(function() {
                            //     commit('Model/addIdToAnimate', order.id, {root: true})
                            //     setTimeout(function() {
                            //         commit('Model/cleanAnimations', "glitter-dentix", {root: true})
                            //     },3000); 
                            // },1000);
                        }
                    }
                    flash({
                        message: 'Pedido enviado. Muchas gracias', 
                        label: 'success'
                    });
                }).catch((error) => {
                    flash({
                            // message: error.response.data, 
                            message: 'Error en el servidor.<br>Por favor, contacte con el administrador de la plataforma', 
                            label: 'danger'
                        });
                    Vue.buttonLoaderRemove(e, classes);
                });
        }
    },
    mutations: {
        setCategory(state, {name=null, model=null, headerText=null, itemKey=null}) {
            if (!state.shoppingCart[name]) {
                Vue.set(state.shoppingCart, name, new ShoppingCartCategory({name, model, headerText, itemKey}));
            }
        },
        shoppingCartToggle(state, {item, category}) {
            // if (!state.shoppingCart[category]) {
            //     Vue.set(state.shoppingCart, category, [item]);
            // }
            if (state.shoppingCart[category].ids.includes(item)) {
              state.shoppingCart[category].ids.splice(state.shoppingCart[category].ids.indexOf(item),1);
            } else {
              state.shoppingCart[category].ids.push(item);
            }
        },
        cleanShoppingCart(state, {categories=null}) {
            if (!categories) {
                for (let cat in state.shoppingCart) {
                    state.shoppingCart[cat].ids = [];
                }
            } else {
                for (let cat of categories) {
                    state.shoppingCart[cat].ids = [];
                }
            }
        }
    }
}