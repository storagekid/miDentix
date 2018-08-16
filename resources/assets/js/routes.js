import VueRouter from 'vue-router';
import Vue from 'vue';
Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: require('./components/stationary/index'),
    },
    {
        path: '/stationary',
        component: require('./components/stationary/index'),
    },
    {
        path: '/providers',
        component: require('./components/providers/index'),
    },
    {
        path: '/clinics',
        component: require('./components/clinics/index'),
    },
    {
        path: '/orders',
        component: require('./components/orders/index'),
    }
];

export default new VueRouter({
    routes
});
