require('./bootstrap');


let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
]



window.Vue = require('vue');
import { slice } from 'lodash';
import Form from 'vform'

//importing Gate that we created
import Gate from "./Gate"

//making gate a prototype
Vue.prototype.$gate = new Gate(window.user);

window.Form = Form;

import VueProgressBar from 'vue-progressbar' // importing Progress Bar


//Color Options for progress bar
const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
}
Vue.use(VueProgressBar, options) // usage of progress bar

import Swal from 'sweetalert2'; // importing sweetalert
window.Swal = Swal;

//variables for sweetalerttoastr
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.toast = toast;

import VueRouter from 'vue-router'; // Import Vue Router for Use Vue Router
import moment from 'moment'; //Import moment js package
import Vue from 'vue';
Vue.use(VueRouter)

// Path routes javascript same route in Laravel PHP


//Creating a global event listener
// let Fire = new Vue();
window.Fire = new Vue();

// Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's

const router = new VueRouter({
    mode: 'history', // use for history for bu
    routes
})


//Global filters to use anywhere
Vue.filter('upText', function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate', function(text) {
    return moment(text).format('MMMM Do YYYY');
});



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('example-component', require('./components/ExampleComponent.vue')); // Componnet for example
import NotFound from './components/404.vue';
components: {
    NotFound
}
Vue.component('not-found', require('./components/404.vue')); // Componnet for 404

const app = new Vue({
    el: '#app',
    router
});