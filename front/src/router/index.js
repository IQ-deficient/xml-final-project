import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Home
    },
    {
        path: '/products',
        name: 'Products',
        component: Home
    },
    {
        path: '/suppliers',
        name: 'Suppliers',
        component: Home
    },
    {
        path: '/sales',
        name: 'Sales',
        component: Home
    },
    {
        path: '/about',
        name: 'About',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router

// In case someone alters the route in browser to non-existent, redirect to home page
router.beforeEach(
    (to, from, next) => {
        if (to.matched.some(record => record.name)) {
            next()
        }
        router.push('/products').catch(() => {
        })
    })
