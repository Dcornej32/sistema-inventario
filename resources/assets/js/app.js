
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//const { default: Axios } = require('axios');
//const { default: Echo } = require('laravel-echo');

require('./bootstrap');
//window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('producto', require('./components/Producto.vue'));
Vue.component('cliente', require('./components/Cliente.vue'));
Vue.component('proveedor', require('./components/Proveedor.vue'));
Vue.component('rol', require('./components/Rol.vue'));
Vue.component('user', require('./components/User.vue'));
Vue.component('informacion', require('./components/Informacion.vue'));
Vue.component('entrada', require('./components/Entrada.vue'));
Vue.component('salida', require('./components/Salida.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('ayuda', require('./components/Ayuda.vue'));
//Vue.component('notification', require('./components/Notification.vue'));



const app = new Vue({
    el: '#app',
    data: {
        menu : 0
        
    },
    
});
