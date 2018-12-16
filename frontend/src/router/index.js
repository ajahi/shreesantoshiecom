import Vue from 'vue'
import Login from '../views/authentication/Login.vue'
import Dashboard from '../views/dashboard.vue'
import Layout from '../views/layout/Layout'

import User from '../views/user/index.vue'
import UserCreate from '../views/user/create.vue'
import UserEdit from '../views/user/edit.vue'


import Role from '../views/role/index.vue'
import RoleCreate from '../views/role/create.vue'
import RoleEdit from '../views/role/edit.vue'


import Permission from '../views/permission/index.vue'
import PermissionCreate from '../views/permission/create.vue'
import PermissionEdit from '../views/permission/edit.vue'

import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/login',
            component: Login,
            meta: {
                forVisitors: true,
                nav: false,
                roles: ['admin']

            },
            hidden: true
        },

        {
            path: '/dashboard',
            component: Layout,
            redirect: '/dashboard/index',
            meta: {
                roles: ['admin']
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
                    roles: ['admin', 'customer']
                }
            }]
        },
        {
            path: '/user',
            component: Layout,
            redirect: '/user/user',
            name: 'User',
            meta: {
                title: 'User',
                icon: 'user',
                forAuth: true,
                nav: false,
                roles: ['admin']
            },
            children: [
                {
                    path: 'user',
                    name: 'User',
                    component: User,
                    meta: {
                        title: 'User',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                },
                {
                    path: 'create',
                    name: 'Create',
                    component: UserCreate,
                    meta: {
                        title: 'User Create',
                        icon: 'edit',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                },
                {
                    path: 'edit/:id(\\d+)',
                    name: 'Edit',
                    component: UserEdit,
                    meta: {
                        title: 'User Edit',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    },
                    hidden: true
                },

            ]
        },

        {
            path: '/role',
            component: Layout,
            redirect: '/role/role',
            name: 'Role',
            meta: {
                title: 'Role',
                icon: 'eye',
                forAuth: true,
                nav: false,
                roles: ['admin']
            },
            children: [
                {
                    path: 'role',
                    name: 'Role',
                    component: Role,
                    meta: {
                        title: 'Role',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                },
                {
                    path: 'create',
                    name: 'Create',
                    component: RoleCreate,
                    meta: {
                        title: 'Role Create',
                        icon: 'edit',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                },
                {
                    path: 'edit/:id(\\d+)',
                    name: 'Edit',
                    component: RoleEdit,
                    meta: {
                        title: 'Role Edit',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    },
                    hidden: true
                },

            ]
        },

        {
            path: '/permission',
            component: Layout,
            redirect: '/permission/permission',
            name: 'Permission',
            meta: {
                title: 'Permission',
                icon: 'star',
                forAuth: true,
                nav: false,
                roles: ['admin']
            },
            children: [
                {
                    path: 'permission',
                    name: 'Permission',
                    component: Permission,
                    meta: {
                        title: 'Permission',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                },
                {
                    path: 'create',
                    name: 'Create',
                    component: PermissionCreate,
                    meta: {
                        title: 'Permission Create',
                        icon: 'edit',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    }
                },
                {
                    path: 'edit/:id(\\d+)',
                    name: 'Edit',
                    component: PermissionEdit,
                    meta: {
                        title: 'Permission Edit',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin']
                    },
                    hidden: true
                },

            ]
        },
        {
            path: '/',
            redirect: '/dashboard',
        },


    ]
})

export default router
