import Vue from 'vue'

import NProgress from 'nprogress'
import Router from './router'
import store from './store'

Router.beforeEach(
  (to, from, next) => {
    NProgress.start()


    if (to.matched.some(record => record.meta.forAuth)) {
      if (!Vue.auth.isAuthenticated()) {
        next({
          path: '/login'
        })
        NProgress.done()
      } else {
        if (store.getters.userid == null) {
          store.dispatch('GetUserInfo').then(() => {
            if (to.meta.roles.includes(store.getters.userrole.name)) {
              next()
            } else {
              next({
                path: '/dashboard'
              })
            }
          })
        } else {
          if (to.meta.roles.includes(store.getters.userrole.name)) {
            next()
          } else {
            next({
              path: '/dashboard'
            })
          }
        }
      }
    } else next()
  }
)

Router.afterEach(() => {
  NProgress.done()
})
