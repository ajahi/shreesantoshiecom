import Vue from 'vue'
import Router from 'vue-router'
import { store } from '../store';
import Site from '../components/site/Site';
import Profile from '../components/Profile';
import User from '../components/User';
import Signup from '../components/site/Signup';
import Signin from '../components/site/Signin'
import HelloWorld from '../components/HelloWorld';
import Supplier from '../components/Supplier';
import SupplierList from '../components/SupplierList';
import NotFound from '../components/site/NotFound';
import AccessDenied from '../components/site/Deny';
import Club from '../components/club/Club'
import ClubList from '../components/club/ClubList'
import Member from '../components/member/Member'
import MemberList from '../components/member/MemberList'
import MemberCrud from '../components/member/MemberCrud'
import ClubCrud from '../components/club/ClubCrud'
import YearCrud from '../components/club/YearCrud'
import YearList from '../components/club/YearList'
import ClubDesignationCrud from '../components/member/ClubDesignationCrud'
import QuoteList from '../components/quote/QuoteList'
import Quote from '../components/quote/Quote'
import EbookList from '../components/ebook/EbookList'
import Ebook from '../components/ebook/Ebook'
import CalendarList from '../components/calendar/CalendarList'
import Calendar from '../components/calendar/Calendar'

const routerOptions = [
    { path: '*',
        redirect: {
            path:'/404'
        }
    },
    {
        path:'/404',
        name:'NotFound',
        component: NotFound
    },
    {
        path:'/403',
        name:'AccessDenied',
        component: AccessDenied
    },
    {   path: '/',
        redirect: {
            name:'home'
        }
    },
    {   path: '/signin',name:'login',component: Signin },
    {   path: '/signup', component: Signup },
    {   path: '/dashboard',name:'dashboard', component: HelloWorld, meta: { requiresAuth: true } },
    {   path: '/dashboard/profile',
        component: User,
        meta: {requiresAuth: true},
        props: true,
        children: [
            {path: '',component: Profile,meta:{requiresAuth:true}},

        ],
     },
    { path:'/dashboard/supplier/:id',name:'supplier',component: Supplier,meta:{requiresAuth:true} ,props:true },
    { path:'/dashboard/suppliers',name:'supplierList',component: SupplierList,meta:{requiresAuth:true} },
    { path:'/dashboard/club/:id',component: Club,meta:{requiresAuth:true}, props:true,
      children: [
          {
              path: '', name:'club', meta:{requiresAuth:true},props:true,
              component:ClubCrud
          },
          {
              path: 'year/:yearid', name:'year', meta:{requiresAuth:true},props:true,
              component:YearCrud
          },
          {
              path: 'years', name:'yearList', meta:{requiresAuth:true},props:true,
              component:YearList
          }
      ]
    },
    { path:'/dashboard/clubs',name:'clubs',component: ClubList,meta:{requiresAuth:true} },
    { path:'/dashboard/member/:id',component: Member,meta:{requiresAuth:true}, props:true,
        children: [
            {
                path: '', name:'member', meta:{requiresAuth:true},props:true,
                component:MemberCrud
            },

        ]
    },
    {
        path: '/dashboard/member/:id/designation', name:'club-designation', meta:{requiresAuth:true},props:true,
        component:ClubDesignationCrud
    },
    { path:'/dashboard/members',name:'members',component: MemberList,meta:{requiresAuth:true} },
    { path:'/dashboard/quote/:id',name:'quote',component: Quote,meta:{requiresAuth:true} ,props:true },
    { path:'/dashboard/quotes',name:'quotes',component: QuoteList,meta:{requiresAuth:true} },
    { path:'/dashboard/ebook/:id',name:'ebook',component: Ebook,meta:{requiresAuth:true} ,props:true },
    { path:'/dashboard/ebooks',name:'ebooks',component: EbookList,meta:{requiresAuth:true} },
    { path:'/dashboard/calendar/:id',name:'calendar',component: Calendar,meta:{requiresAuth:true} ,props:true },
    { path:'/dashboard/calendars',name:'calendars',component: CalendarList,meta:{requiresAuth:true} },
]


/*const routes = routerOptions.map(route => {
    return {
        ...route,
        component: () => import(`@/components/${route.component}.vue`)
    }
})*/

Vue.use(Router)


const  router = new Router({
    mode: 'history',
    routes: routerOptions
})

router.beforeEach((to,from,next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const isAuthenticated = store.state.auth.token;
    if (requiresAuth && !isAuthenticated) {
        next('/signin')
    } else {
        // fetch user
        if(isAuthenticated) {
            store.dispatch('getMe')
        }
        next()
    }
})

export default router
