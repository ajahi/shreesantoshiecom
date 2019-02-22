import axios from 'axios';

export default {
    state: {
        quotes: [],
        quote: {},
    },
    mutations:{
        setQuote(state,payload){
            state.quote = payload

        },
        setQuotes(state,quotes){
            state.quotes = quotes;
        },
        setQuoteId(state,payload){
            state.quote.id = payload
        },

    },
    actions: {
        fetchQuote({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/quote/'+payload)
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setQuote',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchQuotes({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/quote')
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setQuotes',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        saveQuote({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put('/quote/'+payload.id,payload)
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
                    axios.post('/quote',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setQuoteId',response.data.created_id);
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
        deleteQuote({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.delete('/quote/'+payload)
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
        setQuote({commit,state},payload){
            commit('setQuote',payload);
        },
        clearQuote({commit}){
            commit('setQuote',{})
        },

    },
    getters: {
        getQuote:state => {
            return state.quote;
        },
        getQuotes:state => {
            return state.quotes;
        }
    }
}
