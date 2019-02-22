import axios from 'axios';

export default {
    state: {
        suppliers: [],
        supplier: {
            id:'',
            name:'',
            description:'',
            contactNo:'',
            address: '',

        }
    },
    mutations:{
        setSupplier(state,payload){
            state.supplier.id = payload.id;
            state.supplier.name = payload.name;
            state.supplier.description = payload.description;
            state.supplier.contactNo = payload.contactNo;
            state.supplier.address = payload.address;


        },
        setSuppliers(state,suppliers){
            state.suppliers = suppliers;
        },
        setSupplierId(state,payload){
            state.supplier.id = payload
        },
        clearSupplier(state){
            state.supplier.id = '';
            state.supplier.name = '';
            state.supplier.description = '';
            state.supplier.address = '';
            state.supplier.contactNo = '';
        }
    },
    actions: {
        fetchSuppliers({commit,state,rootState}){
            return new Promise(((resolve,reject ) =>{
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/supplier')
                    .then(response =>{
                        commit('setSuppliers',response.data);
                        commit('setLoading',false);
                        resolve(response);
                    })
                    .catch(error => {
                        commit('setAlert',{msg:error.response.data.message,type:'error'})
                        reject(error);
                    })

            }))

        },
        fetchSupplier({commit,state,rootState},payload){
            return new Promise((((resolve, reject) => {
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/supplier/'+payload.id)
                    .then(response => {
                        commit('setSupplier',response.data);
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
        saveSupplier({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put(rootState.serverUrl+'/api/supplier/'+payload.id,payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('clearSupplier');
                            app.dispatch('fetchSuppliers');
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.message,type:'error'});
                            reject(error);
                        });
                }
                else{
                    axios.post(rootState.serverUrl+'/api/supplier',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setSupplierId',response.data.created_id);
                            commit('clearSupplier');
                            app.dispatch('fetchSuppliers');
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
        deleteSupplier({commit,state,rootState},payload){
          return new Promise(((resolve, reject) => {
              commit('setLoading',true);
              const app = this;
              if(payload){
                  axios.delete(rootState.serverUrl+'/api/supplier/'+payload)
                      .then(response => {
                          commit('setLoading',false);
                          commit('setAlert',{msg:response.data.message,type:'success'});
                          app.dispatch('fetchSuppliers');
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
        setSupplier({commit,state},payload){
            commit('setSupplier',payload);
        },
        clearSupplier({commit,state}){
          commit('clearSupplier');
        }
    },
    getters: {
        getSuppliers:state => {
            return state.suppliers;
        },
        getSupplier:state => {
            return state.supplier;
        }
    }
}