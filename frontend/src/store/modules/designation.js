import axios from 'axios';

export default {
    state: {
        designations: [],
        designation: {
        }
    },
    mutations:{
        setDesignation(state,payload){
            state.designation = payload;
        },
        setDesignations(state,payload){
            state.designations = payload;
        },
        setDesignationId(state,payload){
            state.designation.id = payload
        }

    },
    actions: {
        fetchDesignations({commit,state,rootState}){
            commit('setLoading',true);
            axios.get('/designation')
                .then(response =>{
                    commit('setDesignations',response.data);
                    commit('setLoading',false)

                })
                .catch(error => {
                    commit('setAlert',{msg:error.response.data.message,type:'error'})
                })
        },
        setDesignation({commit,state},payload){
            commit('setDesignation',payload);
        }
    },
    getters: {
        getDesignation:state => {
            return state.designations;
        },
        getDesignations:state => {
            return state.designations;
        }
    }
}
