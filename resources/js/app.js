require('./bootstrap');
import Vue from 'vue'
import Vuetify from 'vuetify'
import Router from './router'
import store from './store'
import App from './template/App';

import VueSweetalert2 from 'vue-sweetalert2';

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css';


import VueIziToast from 'vue-izitoast';

import 'izitoast/dist/css/iziToast.css';

Vue.use(VueIziToast);
Vue.use(VueSweetalert2);
Vue.use(Vuetify)
const app = new Vue({
 el: '#app',
 store,
 router:Router,
 vuetify: new Vuetify(),
 render: h=>h(App)
} );
