import Vue from 'vue'
import Login from '../views/authentication/Login.vue'
import Dashboard from '../views/dashboard.vue'
import Layout from '../views/layout/Layout'


import Menu from '../views/menu/index.vue'


import User from '../views/user/index.vue'
import UserCreate from '../views/user/create.vue'
import UserEdit from '../views/user/edit.vue'


import Role from '../views/role/index.vue'
import RoleCreate from '../views/role/create.vue'
import RoleEdit from '../views/role/edit.vue'


import Permission from '../views/permission/index.vue'
import PermissionCreate from '../views/permission/create.vue'
import PermissionEdit from '../views/permission/edit.vue'


import Post from '../views/post/index.vue'
import PostCreate from '../views/post/create.vue'
import PostEdit from '../views/post/edit.vue'

import Category from '../views/category/index.vue'
import CategoryCreate from '../views/category/create.vue'
import CategoryEdit from '../views/category/edit.vue'

import Site from '../views/site/site.vue'


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
            },
            hidden: true
        },

        {
            path: '/dashboard',
            component: Layout,
            redirect: '',
            meta: {
                noCache: true,
                forAuth: true,
                nav: false,
                roles: ['admin','super_admin']
            },
            children: [{
                path: '',
                component: Dashboard,
                name: 'Dashboard',

                meta: {
                    title: 'Dashboard',
                    icon: 'dashboard',
                    noCache: true,
                    forAuth: true,
                    nav: false,
                    roles: ['admin','super_admin']
                }
            }]
        },
        {
            path: '/menu',
            component: Layout,
            redirect: '',

            meta: {
                roles: ['admin','super_admin'],
                forAuth: true,
                nav: false,
            },
            children: [{
                path: '',
                component: Menu,
                name: 'Menu List',

                meta: {
                    title: 'Menu',
                    icon: 'tab',
                    noCache: true,
                    forAuth: true,
                    nav: false,
                    roles: ['admin','super_admin']
                }
            }]
        },
        {
            path: '/user',
            component: Layout,
            redirect: '',
            meta: {
                title: 'User',
                icon: 'user',
                forAuth: true,
                nav: false,
                roles: ['admin','super_admin']
            },
            children: [
                {
                    path: '',
                    name: 'User List',
                    component: User,
                    meta: {
                        title: 'User',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
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
                        roles: ['admin','super_admin']
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
                        roles: ['admin','super_admin']
                    },
                    hidden: true
                },

            ]
        },

        {
            path: '/role',
            component: Layout,
            redirect: '',
            meta: {
                title: 'Role',
                icon: 'eye',
                forAuth: true,
                nav: false,
                roles: ['admin','super_admin']
            },
            children: [
                {
                    path: '',
                    name: 'Role List',
                    component: Role,
                    meta: {
                        title: 'Role',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'create',
                    name: 'Role Create',
                    component: RoleCreate,
                    meta: {
                        title: 'Role Create',
                        icon: 'edit',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'edit/:id(\\d+)',
                    name: 'Role Edit',
                    component: RoleEdit,
                    meta: {
                        title: 'Role Edit',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    },
                    hidden: true
                },

            ]
        },

        {
            path: '/permission',
            component: Layout,
            redirect: '',
            meta: {
                title: 'Permission',
                icon: 'star',
                forAuth: true,
                nav: false,
                roles: ['admin','super_admin']
            },
            children: [
                {
                    path: '',
                    name: 'Permission List',
                    component: Permission,
                    meta: {
                        title: 'Permission',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'create',
                    name: 'Permission Create',
                    component: PermissionCreate,
                    meta: {
                        title: 'Permission Create',
                        icon: 'edit',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'edit/:id(\\d+)',
                    name: 'Permission Edit',
                    component: PermissionEdit,
                    meta: {
                        title: 'Permission Edit',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    },
                    hidden: true
                },

            ]
        },

        {
            path: '/post',
            component: Layout,
            redirect: '',
            meta: {
                title: 'Post',
                icon: 'excel',
                forAuth: true,
                nav: false,
                roles: ['admin','super_admin']
            },
            children: [
                {
                    path: '',
                    name: 'post',
                    component: Post,
                    meta: {
                        title: 'Post',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'create',
                    name: 'PostCreate',
                    component: PostCreate,
                    meta: {
                        title: 'Post Create',
                        icon: 'edit',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'edit/:id(\\d+)',
                    name: 'PostEdit',
                    component: PostEdit,
                    meta: {
                        title: 'Post Edit',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    },
                    hidden: true
                },

            ]
        },
        {
            path: '/category',
            component: Layout,
            redirect: '',
            meta: {
                title: 'Category',
                icon: 'example',
                forAuth: true,
                nav: false,
                roles: ['admin','super_admin']
            },
            children: [
                {
                    path: '',
                    name: 'category',
                    component: Category,
                    meta: {
                        title: 'Category',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'create',
                    name: 'CategoryCreate',
                    component: CategoryCreate,
                    meta: {
                        title: 'Category Create',
                        icon: 'edit',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    }
                },
                {
                    path: 'edit/:id(\\d+)',
                    name: 'CategoryEdit',
                    component: CategoryEdit,
                    meta: {
                        title: 'Category Edit',
                        icon: 'table',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    },
                    hidden: true
                },

            ]
        },
        {
            path: '/site',
            component: Layout,
            redirect: '',
            meta: {
                title: 'Site',
                icon: 'example',
                forAuth: true,
                nav: false,
                roles: ['admin','super_admin']
            },
            hidden: false,

            children: [
                {
                    path: '',
                    name: 'site',
                    component: Site,
                    meta: {
                        title: 'Site',
                        icon: 'list',
                        forAuth: true,
                        nav: false,
                        roles: ['admin','super_admin']
                    },


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
