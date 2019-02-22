import axios from 'axios';

export default {
    state: {
        ebooks: [],
        ebook: {},
    },
    mutations:{
        setEbook(state,payload){
            state.ebook = payload

        },
        setEbooks(state,ebooks){
            state.ebooks = ebooks;
        },
        setEbookId(state,payload){
            state.ebook.id = payload
        },

    },
    actions: {
        fetchEbook({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/ebook/'+payload)
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setEbook',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchEbooks({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/ebook')
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setEbooks',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        saveEbook({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put('/ebook/'+payload.id,payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.errors,type:'error'});
                            reject(error);
                        });
                }
                else{
                    axios.post('/ebook',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setEbookId',response.data.created_id);
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.errors,type:'error'});
                            reject(error);
                        });
                }

            }))


        },

        deleteEbook({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.delete('/ebook/'+payload)
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setAlert',{msg:response.data.message,type:'success'});
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        setEbook({commit,state},payload){
            commit('setEbook',payload);
        },
        clearEbook({commit}){
            commit('setEbook',{})
        },

    },
    getters: {
        getEbook:state => {
            return state.ebook;
        },
        getEbooks:state => {
            return state.ebooks;
        }
    }
}
