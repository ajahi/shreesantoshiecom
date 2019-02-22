import Vue from 'vue'
import Vuex from 'vuex'
import auth from './modules/auth'
import profile from './modules/profile'
import app from './modules/app'
import club from './modules/club'
import member from './modules/member'
import enums from './modules/enums'
import designation from  './modules/designation'
import quote from  './modules/quote'
import ebook from  './modules/ebook'
import calendar from  './modules/calendar'

Vue.use(Vuex)

export const store = new Vuex.Store({
    modules: {
        auth,
        profile,
        app,
        club,
        member,
        enums,
        designation,
        quote,
        ebook,
        calendar
    },
    state: {
        appTitle: 'Mis for Divine Youth Club Nepal',
        //user: null,
        alertMsg: null,
        alertType: 'success',
        loading: false,
        layout: 'app-layout',
        /*serverUrl: 'http://localhost:8080',*/
        serverUrl: process.env.VUE_APP_SERVER_URL,
    },
    mutations: {
       /* setUser(state, payload) {
            state.user = payload
        },*/
       setAlert(state,payload){
         state.alertMsg = payload.msg;
         state.alertType = payload.type;
       },
        setAlertMsg(state, payload) {
            state.alertMsg = payload
        },
        setAlertType(state,payload){
            state.alertType = payload
        },
        setLoading(state, payload) {
            state.loading = payload
        },
        setLayout(state, payload) {
            state.layout = payload
        },

    },
    actions: {


    },
    getters: {
        layout(state) {
            return state.layout
        },
        fbLoginUrl(state){
            return state.serverUrl + '/auth/facebook?scope=email,user_location'
        },
        googleLoginUrl(state){
            return state.serverUrl + '/auth/google'
        },
        loading(state){
            return state.loading
        },
        getServerUrl(state){
            return state.serverUrl;
        },
        getAlertMsg(state){
            return state.alertMsg;
        },
        getAlertType(state){
            return state.alertType;
        }




    },
})
