import Vue from 'vue'
import ElementUI from 'element-ui';
import 'normalize.css/normalize.css'// A modern alternative to CSS resets
import locale from 'element-ui/lib/locale/lang/en' // lang i18n
import './styles/index.scss' // global css

import 'element-ui/lib/theme-chalk/index.css';
import 'element-ui/lib/theme-chalk/display.css';
import App from './App.vue'
import Router from './router/index.js'
import VueResource from 'vue-resource'
import Auth from './packages/auth/auth.js'
import axios from 'axios';
import store from './store'
import './icons' // icon

import './axios.js'
import './permission.js'


Vue.use(VueResource)
Vue.use(Auth)
Vue.use(require('vue-moment'));
Vue.use(axios)
Vue.use(ElementUI, { locale })


window.vm = new Vue({
    el: '#app',
    store,
    render: h => h(App),
    router: Router
})
