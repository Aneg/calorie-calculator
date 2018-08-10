import Vue from 'vue'
import Router from 'vue-router'
import store from '../store/store'
import Products from '../components/Products'
import Product from '../components/Product'
import ProductsTable from '../components/ProductsTable'
import Baskets from '../components/Baskets'
import Basket from '../components/Basket'
import Login from '../components/Login'
import Home from '../components/Home'

Vue.use(Router);

const ifNotAuthenticated = (to, from, next) => {
  if (!store.getters.isAuthenticated) {
    next();
    return
  }
  next('/')
};

const ifAuthenticated = (to, from, next) => {
  if (store.getters.isAuthenticated) {
    next();
    return
  }
  next('/login')
};

export default new Router({
  mode: 'history',
  routes: [
    {
        path: '/',
        name: 'home',
        component: Home,
        beforeEnter: ifAuthenticated,
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      beforeEnter: ifNotAuthenticated,
    },
    {
      path: '/products/create',
      name: 'create',
      component: Product,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/products/:id/edit',
      name: 'product',
      component: Product,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/products',
      component: Products,
      beforeEnter: ifAuthenticated,
      children: [
        {
          path: '',
          name: 'products',
          component: ProductsTable,
          beforeEnter: ifAuthenticated,
        },
        {
          path: ':page',
          name: 'products-page',
          component: ProductsTable,
          beforeEnter: ifAuthenticated,
        }
      ]
    },
    {
      path: '/baskets',
      name: 'baskets',
      component: Baskets,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/baskets/create',
      name: 'baskets-create',
      component: Basket,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/baskets/:page',
      name: 'baskets-page',
      component: Baskets,
      beforeEnter: ifAuthenticated
    },
    {
      path: '/baskets/:id/edit',
      name: 'basket',
      component: Basket,
      beforeEnter: ifAuthenticated
    }
  ]
})
