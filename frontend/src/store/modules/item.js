import axios from 'axios';

export default {
    state: {
        items: [],
        item: {
            id:'',
            name:'',
            description:'',
            category: '',
            price:'',
            stock: '',
            categoryId: ''
        }
    },
    mutations:{
        setItem(state,payload){
            state.item.id = payload.id;
            state.item.name = payload.name;
            state.item.description = payload.description;
            state.item.price = payload.price;
            state.item.stock = payload.stock;
            if(payload.category){
                state.item.categoryId= payload.category.id;
                state.item.category = payload.category;
            }
        },
        setItems(state,items){
            state.items = items;
        },
        setItemId(state,payload){
            state.item.id = payload
        },
        clearItem(state){
            state.item.id = '';
            state.item.name = '';
            state.item.description = '';
            state.item.price = '';
            state.item.stock = '';
            state.item.categoryId= '';
            //state.item.category = '';

        }
    },
    actions: {
        fetchItems({commit,state,rootState}){
            return new Promise(((resolve,reject ) =>{
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/item')
                    .then(response =>{
                        commit('setItems',response.data);
                        commit('setLoading',false);
                        resolve(response);
                    })
                    .catch(error => {
                        commit('setAlert',{msg:error.response.data.message,type:'error'})
                        reject(error);
                    })

            }))

        },
        fetchItem({commit,state,rootState},payload){
            return new Promise((((resolve, reject) => {
                commit('setLoading',true);
                axios.get(rootState.serverUrl+'/api/item/'+payload.id)
                    .then(response => {
                        commit('setItem',response.data);
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
        saveItem({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put(rootState.serverUrl+'/api/item/'+payload.id,payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('clearItem');
                            app.dispatch('fetchItems');
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.message,type:'error'});
                            reject(error);
                        });
                }
                else{
                    axios.post(rootState.serverUrl+'/api/item',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setItemId',response.data.created_id);
                            commit('clearItem');
                            app.dispatch('fetchItems');
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
        deleteItem({commit,state,rootState},payload){
          return new Promise(((resolve, reject) => {
              commit('setLoading',true);
              const app = this;
              if(payload){
                  axios.delete(rootState.serverUrl+'/api/item/'+payload)
                      .then(response => {
                          commit('setLoading',false);
                          commit('setAlert',{msg:response.data.message,type:'success'});
                          app.dispatch('fetchItems');
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
        setItem({commit,state},payload){
            commit('setItem',payload);
        },
        clearItem({commit,state}){
          commit('clearItem');
        }
    },
    getters: {
        getItems:state => {
            return state.items;
        },
        getItem:state => {
            return state.item;
        }
    }
}