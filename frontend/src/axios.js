import Vue from 'vue'

import axios from 'axios';
import store from "./store";


axios.defaults.baseURL = process.env.BASE_API
axios.interceptors.request.use(async function (config) {

        if (store.getters.token) {
            config.headers['Authorization'] = `Bearer ${Vue.auth.getToken()}`
            config.headers['Content-Type'] = 'application/json'
        }
        return config
    },
    function (error) {
        console.error(error)
        return Promise.reject(error);
    });

//
// axios.interceptors.response.use(
//     response => {
//
//
//         const res = response
//
//         console.log(res)
//         if (res.status !== 200) {
//             Message({
//                 message: "un",
//                 type: 'error',
//                 duration: 5 * 1000
//             })
//             return Promise.reject('error')
//         } else {
//             return response
//         }
//     },
//     error => {
//
//         // console.log('err' + error)
//         // Message({
//         //     message: error.message,
//         //     type: 'error',
//         //     duration: 5 * 1000
//         // })
//         return Promise.reject(error)
//     }
// )
Vue.prototype.$axios = axios;

