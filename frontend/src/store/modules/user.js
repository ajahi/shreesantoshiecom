import Vue from 'vue'
import Auth from '../../packages/auth/auth.js'
import axios from 'axios/index'
import { Message } from 'element-ui'
import Route from '../../router/index.js'

Vue.use(Auth)

const user = {
  state: {
    id: null,
    name: null,
    avatar: null,
    token: Vue.auth.getToken(),
    roles: null,
    email: null,
    active: null,
    verified: null
  },

  mutations: {
    SET_ID: (state, id) => {
      state.id = id
    },
    SET_TOKEN: (state, token) => {
      state.token = token
    },
    SET_NAME: (state, name) => {
      state.name = name
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar
    },
    SET_EMAIL: (state, email) => {
      state.email = email
    },
    SET_ROLES: (state, roles) => {
      state.roles = roles
    },
    SET_ACTIVE: (state, active) => {
      state.active = active
    },
    SET_VERIFIED: (state, verified) => {
      state.verified = verified
    }
  },

  actions: {

    Login({ commit }, userInfo) {
      return new Promise((resolve, reject) => {
        axios.post('/login', userInfo).then(response => {
          const data = response.data
          Vue.auth.setToken(data.access_token, data.expires_at + Date.now())
          commit('SET_TOKEN', data.access_token)
          commit('SET_ID', data.id)
          resolve(data)
        }).catch(error => {
          if (!error.response.data.message) {
            const data = error.response.data[0]
            commit('SET_ROLES', data.roles[0])
            commit('SET_NAME', data.name)
            commit('SET_ID', data.id)
            commit('SET_AVATAR', data.avatar)
            commit('SET_EMAIL', data.email)
            commit('SET_ACTIVE', data.status)
            commit('SET_VERIFIED', data.verified)

            if (data.status === 'inactive' || data.verified === false) {
              this.show = false
              // if (data.verified === false) {
              //   Message({
              //     message: 'Check Your email for code',
              //     type: 'success',
              //     duration: 5 * 1000
              //   })
              // }
              //
              // Route.push({ path: '/verify' })
              resolve(data)
            } else {
              Message({
                message: 'Invalid Login',
                type: 'error',
                duration: 5 * 1000
              })
              reject()
            }
          } else {
            Message({
              message: error.response.data.message,
              type: 'error',
              duration: 5 * 1000
            })
            reject()
          }
        })
      })
    },


    SetUser({ commit }, data) {
      return new Promise((resolve) => {
        commit('SET_ROLES', data.roles[0])
        commit('SET_NAME', data.name)
        commit('SET_ID', data.id)
        commit('SET_AVATAR', data.avatar)
        commit('SET_EMAIL', data.email)
        commit('SET_ACTIVE', data.status)
        commit('SET_VERIFIED', data.verified)

        resolve()
      })
    },
    GetUserInfo({ commit }) {
      return new Promise((resolve, reject) => {
        axios.get('/auth/user').then(response => {
          const data = response.data.data
          commit('SET_ROLES', data.roles[0])
          commit('SET_NAME', data.name)
          commit('SET_ID', data.id)
          commit('SET_AVATAR', data.avatar)
          commit('SET_EMAIL', data.email)
          commit('SET_ACTIVE', data.status)
          commit('SET_VERIFIED', data.verified)

          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    LogOut({ commit }) {
      return new Promise((resolve, reject) => {
        axios.get('/logout/').then(() => {
          commit('SET_TOKEN', '')
          commit('SET_ROLES', [])
          Vue.auth.destroyToken()
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    }

  }
}

export default user
