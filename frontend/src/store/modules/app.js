import Cookies from 'js-cookie'
import axios from "axios/index";

const app = {
    state: {
        sidebar: {
            opened: !+Cookies.get('sidebarStatus'),
            withoutAnimation: false
        },
        device: 'desktop',
        app: null
    },
    mutations: {
        TOGGLE_SIDEBAR: state => {
            if (state.sidebar.opened) {
                Cookies.set('sidebarStatus', 1)
            } else {
                Cookies.set('sidebarStatus', 0)
            }
            state.sidebar.opened = !state.sidebar.opened
            state.sidebar.withoutAnimation = false
        },
        CLOSE_SIDEBAR: (state, withoutAnimation) => {
            Cookies.set('sidebarStatus', 1)
            state.sidebar.opened = false
            state.sidebar.withoutAnimation = withoutAnimation
        },
        TOGGLE_DEVICE: (state, device) => {
            state.device = device
        }
        ,
        SET_APP: (state, app) => {
            state.app = app
        }
    },
    actions: {
        ToggleSideBar: ({commit}) => {
            commit('TOGGLE_SIDEBAR')
        },
        CloseSideBar({commit}, {withoutAnimation}) {
            commit('CLOSE_SIDEBAR', withoutAnimation)
        },
        ToggleDevice({commit}, device) {
            commit('TOGGLE_DEVICE', device)
        },
        App({commit}) {
            return new Promise((resolve, reject) => {
                axios.get("/")
                    .then(response => {
                        const data = response.data
                        commit('SET_APP', data)
                        resolve()
                    }).catch(error => {
                    reject(error)
                })
            })
        }
    }
}

export default app
