import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import Home from './components/Home'
import View from './components/View'
import Plan from './components/Plan'
import AccessManager from './components/AccessManager'
let router = new VueRouter({
 mode: 'history',
 routes: [
 {
 path: '/',
 name: 'Home',
 component: Home
 } ,
  {
 path: '/View',
 name: 'View',
 component: View
 } ,
  {
 path: '/Plan',
 name: 'Plan',
 component: Plan
 } ,
  {
 path: '/AccessManager',
 name: 'AccessManager',
 component: AccessManager
 } ,
 ],
} );


router.beforeEach((to, from, next) =>{
    if(to.name == null){
        next({name: 'Home'})
    }
    else{
      next()  
    }
})


export default router