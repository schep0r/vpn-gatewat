require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import App from './views/App'
import Company from './views/Company'
import User from './views/User'
import Home from './views/Home'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/users',
            name: 'users',
            component: User,
        },
        {
            path: '/companies',
            name: 'companies',
            component: Company,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});