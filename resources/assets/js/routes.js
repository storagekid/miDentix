import VueRouter from 'vue-router';
import Vue from 'vue';
import Store from './store';
Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: require('./components/orders/index'),
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
        path: '/profiles',
        component: require('./components/profiles/index'),
    },
    {
        path: '/personal-tags',
        component: require('./components/personalTags/index'),
    },
    {
        path: '/business-card',
        component: require('./components/businessCard/index'),
    },
    {
        path: '/directory',
        component: require('./components/medicalChart/index'),
    },
    {
        path: '/orders',
        component: require('./components/orders/index'),
        // beforeEnter: (to, from, next) => {
        // }
    },
    {
        path: '/passport',
        component: require('./components/passport/index'),
    },
];

const router = new VueRouter({
    routes,
});

// router.beforeResolve((to, from, next) => {
//     if (!Store.getters['Scope/ready']) {
//         const watcher = Store.watch((state, getters) => {
//             if (getters.ready) {
//                 if (state.User.user.profiles.length > 1) {
//                     console.log('Moreeee');
//                     next('/profile-selector');
//                 } else {
//                     next();                    
//                 }
//             } 
//             else {
//                 console.log('There');
//                 next();
//             }
//         });
//     }
//     else next();
// });

export default router;