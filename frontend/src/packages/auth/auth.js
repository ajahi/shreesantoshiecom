export default function(Vue) {
  Vue.auth = {
    getToken() {
      var token = localStorage.getItem('token')
      var expire = localStorage.getItem('expire')

      if (!token || !expire) {
        return null
      }

      if (Date.now() > parseInt(expire)) {
        this.destroyToken()
        return null
      } else {
        return token
      }
    },

    setToken(token, expire) {
      localStorage.setItem('token', token)
      localStorage.setItem('expire', expire)
    },

    destroyToken() {
      localStorage.removeItem('token')
      localStorage.removeItem('expire')
    },

    isAuthenticated() {
      if (this.getToken()) {
        return true
      } else {
        return false
      }
    }

  }

  Object.defineProperties(Vue.prototype, {
    $auth: {
      get: () => {
        return Vue.auth
      }
    }
  })
}
