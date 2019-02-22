import axios from 'axios';

export default {
    state: {
        categories: [],
        category: {
            id:'',
            name:'',
            parent: ''
        }
    },
    mutations:{
        setCategory(state,payload){
            state.category.id = payload.id;
            state.category.name = payload.name;
            if(payload.parent){
                state.category.parent= payload.parent.id;
            }
        },
        setCategories(state,categorys){
            state.categories = categorys;
        },
        setCategoryId(state,payload){
            state.category.id = payload
        }

    },
    actions: {
        fetchCategories({commit,state,rootState}){
            commit('setLoading',true);
            axios.get(rootState.serverUrl+'/api/category')
                .then(response =>{
                    commit('setCategories',response.data);
                    commit('setLoading',false)

                })
                .catch(error => {
                    commit('setAlert',{msg:error.response.data.message,type:'error'})
                })
        },
        saveCategory({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put(rootState.serverUrl+'/api/category/'+payload.id,payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            app.dispatch('fetchCategories');
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.message,type:'error'});
                            reject(error);
                        });
                }
                else{
                    axios.post(rootState.serverUrl+'/api/category',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setCategoryId',response.data.created_id);
                            app.dispatch('fetchCategories');
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
        setCategory({commit,state},payload){
            commit('setCategory',payload);
        }
    },
    getters: {
        getCategories:state => {
            return state.categories;
        },
        getCategory:state => {
            return state.category;
        }
    }
}