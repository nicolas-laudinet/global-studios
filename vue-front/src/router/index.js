import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import StudiosList from '@/components/StudiosList'
import StudioSingle from '@/components/StudioSingle'
import Contact from '@/components/Contact'
import PageNotFound from '@/components/PageNotFound'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/list',
      name: 'StudiosList',
      component: StudiosList
    },
    {
      path: '/studio/:id',
      name: 'StudioSingle',
      component: StudioSingle
    },
    {
      path: '/contact',
      name: 'Contact',
      component: Contact
    },
    {
      path: '*',
      name: 'PageNotFound',
      component: PageNotFound
    }
  ]
})
