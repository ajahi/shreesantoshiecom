import Vue from 'vue'
import Login from '../views/authentication/Login.vue'
import Home from '../views/home.vue'
import Dashboard from '../views/dashboard.vue'
import Layout from '../views/layout/Layout'
import Table from '../views/user/index.vue'
import Register from '../views/authentication/Register.vue'
import Verify from '../views/authentication/Verify.vue'
import Router from 'vue-router'




import App from '../views/app/index.vue'
import Slide from '../views/app/slide.vue'
import Menu from '../views/app/menu.vue'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: "/login",
            component: Login,
            meta: {
                forVisitors: true,
                nav: false,
                roles: ['admin','customer']

            }
            , hidden: true
        },
        {
            path: "/register",
            component: Register,
            meta: {
                forVisitors: true,
                nav: false,
                roles: ['admin','customer']

            }
            , hidden: true
        },
        {
            path: "/verify",
            component: Verify,
            meta: {
                forVisitors: true,
                nav: false,
                roles: ['admin','customer']

            }
            , hidden: true
        },
        {
            path: '/dashboard',
            component: Layout,
            redirect: '/dashboard/index',
            meta: {
                roles: ['admin','customer']
            },
            children: [{
                path: 'index',
                component: Dashboard,
                name: 'dashboard',

                meta: {
                    title: 'dashboard',
                    icon: 'dashboard',
                    noCache: true,
                    forAuth: true,
                    nav: false,
                    roles: ['admin','customer']
                }
            }]
        },
        {
            path: '/user',
            component: Layout,
            redirect: '/user/list',
            name: 'User',
            meta: {
                title: 'User',
                icon: 'example',
                forAuth: true,
                nav: false,
                roles: ['admin']
            },
            children: [
                {
                    path: 'list',
                    name: 'List',
                    component: Table,
                    meta: {
                        title: 'User',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                }

            ]
        },
        {
            path: "/",
            component: Home,
            meta: {
                forVisitors: true,
                nav: true,
                roles: ['admin','customer']

            }
            , hidden: true
        },

        {
            path: '/app',
            component: Layout,
            redirect: '/app/app',
            name: 'App',
            meta: {
                title: 'App',
                icon: 'example',
                forAuth: true,
                nav: false,
                roles: ['admin']
            },
            children: [
                {
                    path: 'app',
                    name: 'app',
                    component: App,
                    meta: {
                        title: 'App',
                        icon: 'example',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                },
                {
                    path: 'slide',
                    component: Slide,
                    name: 'Slide',
                    meta: {
                        title: 'Slide',
                        noCache: true,
                        nav: false,
                        roles: ['admin']
                    },
                    hidden: true,
                }
                ,
                {
                    path: 'menu',
                    component: Menu,
                    name: 'Menu',
                    meta: {
                        title: 'Menu',
                        noCache: true,
                        nav: false,
                        roles: ['admin']
                    },
                    hidden: true,
                },


            ]
        },
    ]
})

export default router