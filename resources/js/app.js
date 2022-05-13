/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

require('@fortawesome/free-solid-svg-icons');
require('@fortawesome/free-regular-svg-icons');
require('@fortawesome/vue-fontawesome');
require('@fortawesome/fontawesome-svg-core');


window.Vue = require('vue').default;



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('doctor-component', require('./components/DoctorComponent.vue').default);



const app = new Vue({
    el: '#app',
});
