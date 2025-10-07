import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import Home from './components/Home'
import View from './components/View'
import AccessManager from './components/AccessManager'
export default new VueRouter({
 mode: 'history',
 routes: [

  {
 path: '/View',
 name: 'View',
 component: View
 } ,
  {
 path: '/AccessManager',
 name: 'AccessManager',
 component: AccessManager
 } ,
 ],
} );
