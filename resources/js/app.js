Vue.prototype.$toast = toast
require('./bootstrap');




import Vue from 'vue'
import { Form, HasError, AlertError } from 'vform'
import moment from 'moment'
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


window.swal = swal;


window.Vue = require('vue');

Vue.use(VueRouter)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    width: 300,
    timer: 3000
  });

window.toast = toast;
window.Form = Form;

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '2px'
  })

const routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default},
    { path: '/users', component: require('./components/Users.vue').default},
    { path: '/developer', component: require('./components/Developer.vue').default},
    { path: '*', component: require('./components/NotFound.vue').default}
  ]

const router = new VueRouter({
    mode: 'history',
    routes
  })

  Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1);
  });

  Vue.filter('myDate', function(created){
    return moment(created).format('MMMM Do YYYY');
  });


  window.Fire = new Vue();

  Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components//NotFound.vue').default
);

Vue.component('dashboard', require('./components/Dashboard.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('users', require('./components/Users.vue').default);


const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods:{
        searchit: _.debounce(()=>{
            Fire.$emit('searching');
        },1000)
    }
});
