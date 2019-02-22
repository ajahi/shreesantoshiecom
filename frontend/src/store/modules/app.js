import axios from 'axios';

export default {
    state: {
        snackbar: {
            show:false,
            text: '',
            color: ''
        }
    },
    mutations:{
        setSnackbar(state,payload){
            state.snackbar.show = payload.show;
            state.snackbar.text = payload.text;
            state.snackbar.color = payload.color;

        },



    },
    actions: {
            setSnackbar({commit,state},payload){
                commit('setSnackbar',payload)
            },
            showSuccessSnackbar({commit,state},payload){
                commit('setSnackbar',{ show: 'true', text: payload, color:'green'})

            },
            showErrorSnackbar({commit,state},payload){
                commit('setSnackbar',{ show: 'true', text: payload, color:'red'})


            }
            },
    getters: {
        getSnackbar:state => {
            return state.snackbar;
        },

    }
}
