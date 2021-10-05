require('./bootstrap');


let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
]


window.Vue = require('vue');

import VueRouter from 'vue-router' // Import Vue Router for Use Vue Router
Vue.use(VueRouter)

// Path routes javascript same route in Laravel PHP


// Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's

const router = new VueRouter({
    mode: 'history', // use for history for bu
    routes
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue')); // Componnet for example

const app = new Vue({
    el: '#app',
    router
});