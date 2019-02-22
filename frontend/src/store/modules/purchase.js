import axios from 'axios';

export default {
    state: {
        purchases: [],
        purchase: {
            id:'',
            narration:'',
            voucherNo:'',
            totalPrice: '',
            billNature:'',
            date:new Date().toISOString(),
            purchaseDetails: [],
            supplierId:''
        },
        purchaseDetail: {
            id:'',
            name: '',
            categoryName:'',
            quantity:'',
            price:'',
            totalPrice: ''
        }
    },
    mutations:{
        setPurchase(state,payload){
            state.purchase.id = payload.id;
            state.purchase.narration = payload.narration;
            state.purchase.voucherNo = payload.voucherNo;
            state.purchase.totalPrice = payload.totalPrice;
            state.purchase.billNature = payload.billNature;
            state.purchase.date = payload.date;
            state.purchase.supplierId = payload.supplier !== null?payload.supplier.id:''

        },
        setPurchases(state,items){
            state.purchases = items;
        },
        setPurchaseId(state,payload){
            state.purchase.id = payload
        }

    },
    actions: {
        fetchPurchases({commit,state,rootState}){
            return new Promise(((resolve,reject ) =>{
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/purchase')
                    .then(response =>{
                        commit('setPurchases',response.data);
                        commit('setLoading',false);
                        resolve(response);
                    })
                    .catch(error => {
                        commit('setAlert',{msg:error.response.data.message,type:'error'})
                        reject(error);
                    })

            }))

        },
        fetchPurchase({commit,state,rootState},payload){
            return new Promise((((resolve, reject) => {
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/purchase/'+payload.id)
                    .then(response => {
                        commit('setPurchase',response.data);
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
        savePurchase({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put(rootState.serverUrl+'/api/purchase/'+payload.id,payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            app.dispatch('fetchPurchases');
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.message,type:'error'});
                            reject(error);
                        });
                }
                else{
                    axios.post(rootState.serverUrl+'/api/purchase',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            app.dispatch('fetchPurchases');
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
        deletePurchase({commit,state,rootState},payload){
          return new Promise(((resolve, reject) => {
              commit('setLoading',true);
              const app = this;
              if(payload){
                  axios.delete(rootState.serverUrl+'/api/purchase/'+payload)
                      .then(response => {
                          commit('setLoading',false);
                          commit('setAlert',{msg:response.data.message,type:'success'});
                          app.dispatch('fetchPurchases');
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
        setPurchase({commit,state},payload){
            commit('setPurchase',payload);
        }
    },
    getters: {
        getPurchases:state => {
            return state.purchases;
        },
        getPurchase:state => {
            return state.purchase;
        }
    }
}