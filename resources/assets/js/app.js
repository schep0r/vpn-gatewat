require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import App from './views/App'
import Home from './views/Home'
import User from './views/User'
import Company from './views/Company'
import Abuser from './views/Abuser'

const API_URL = 'http://127.0.0.1:8000/api';

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
        {
            path: '/abusers',
            name: 'abusers',
            component: Abuser,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});