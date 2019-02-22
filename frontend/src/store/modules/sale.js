import axios from 'axios';

export default {
    state: {
        sales: [],
        sale: {
            id:'',
            narration:'',
            totalPrice: '',
            saleDetails: []
        },
        saleDetail: {
            id:'',
            name: '',
            categoryName:'',
            quantity:'',
            price:'',
            totalPrice: ''
        }
    },
    mutations:{
        setSale(state,payload){
            state.sale.id = payload.id;
            state.sale.narration = payload.narration;
            state.sale.totalPrice = payload.totalPrice;


        },
        setSales(state,items){
            state.sales = items;
        },
        setSaleId(state,payload){
            state.sale.id = payload
        }

    },
    actions: {
        fetchSales({commit,state,rootState}){
            return new Promise(((resolve,reject ) =>{
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/sale')
                    .then(response =>{
                        commit('setSales',response.data);
                        commit('setLoading',false);
                        resolve(response);
                    })
                    .catch(error => {
                        commit('setAlert',{msg:error.response.data.message,type:'error'})
                        reject(error);
                    })

            }))

        },
        fetchSale({commit,state,rootState},payload){
            return new Promise((((resolve, reject) => {
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/sale/'+payload.id)
                    .then(response => {
                        commit('setSale',response.data);
                        commit('setLoading',false);
                        commit('setAlertMsg',null);
                        resolve(response);
                    })
                    .catch(error => {
                        commit('setAlert',{msg:error.response.data.message,type:'error'})
                        reject(error);
                    })
            })))
        },
        saveSale({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put(rootState.serverUrl+'/api/sale/'+payload.id,payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            app.dispatch('fetchSales');
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.message,type:'error'});
                            reject(error);
                        });
                }
                else{
                    axios.post(rootState.serverUrl+'/api/sale',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            app.dispatch('fetchSales');
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.message,type:'error'});
                            reject(error);
                        });
                }

            }))


        },
        deleteSale({commit,state,rootState},payload){
          return new Promise(((resolve, reject) => {
              commit('setLoading',true);
              const app = this;
              if(payload){
                  axios.delete(rootState.serverUrl+'/api/sale/'+payload)
                      .then(response => {
                          commit('setLoading',false);
                          commit('setAlert',{msg:response.data.message,type:'success'});
                          app.dispatch('fetchSales');
                          resolve(response);
                      })
                      .catch(error => {
                          commit('setLoading',false);
                          commit('setAlert',{msg:error.response.data.message,type:'error'});
                          reject(error);

                      });
              }
          }))
        },
        setSale({commit,state},payload){
            commit('setSale',payload);
        }
    },
    getters: {
        getSales:state => {
            return state.sales;
        },
        getSale:state => {
            return state.sale;
        }
    }
}