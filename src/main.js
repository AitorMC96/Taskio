import { createApp } from 'vue'
import Vue from "vue"
import Router from "vue-router"
import App from "./App";

import HomeView from './views/HomeView.vue';
import Login from './views/LoginView.vue';
//import Registre from "./views/Registre";

Vue.use(Router);

const rutes = [
    { path: "/", component: HomeView },
    { path: "/login", component: Login }
    //{ path: "/registre", component: Registre }
];

const router = new Router({
    rutes
})

createApp(App).use(router).mount('#app')
