import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import Home from './components/Home'
import NPS from './components/NPS'
import BHM from './components/BHM'
import HPS from './components/HPS'
import ID from './components/ID'
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
 path: '/NPS',
 name: 'NPS',
 component: NPS
 } ,
  {
 path: '/BHM',
 name: 'BHM',
 component: BHM
 } ,
  {
 path: '/ID',
 name: 'ID',
 component: ID
 } ,
   {
 path: '/HPS',
 name: 'HPS',
 component: HPS
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