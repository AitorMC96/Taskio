import { createApp } from 'vue';
import Vue from 'vue';
import Router from 'vue-router';
import App from './App';

import Home from './views/HomeView.vue';
import Login from './views/LoginView.vue';
import Registre from './views/RegistreView.vue';

Vue.use(Router);

const rutes = [
    { path: "/", component: Home },
    { path: "/login", component: Login },
    { path: "/registre", component: Registre }
];

const router = new Router({
    rutes
})

createApp(App).use(router).mount('#app')