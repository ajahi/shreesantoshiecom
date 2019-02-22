import axios from 'axios';

export default {
    state: {
        business: {
            id: '',
            name: '',
            description: '',
            phone: '',
            website: '',
            googleBusinessId: '',
            rating: 0,
            hours: '',
            categoryId: '',
            locationId: '',
            gallerySet: []
        },
        businesses: []
    },
    mutations: {
        setBusiness(state,payload){
            state.business.id = payload.id;
            state.business.title = payload.name;
            state.business.description = payload.description;
            state.business.phone = payload.phone;
            state.business.website = payload.website;
            state.business.googleBusinessId = payload.googleBusinessId;
            state.business.rating = payload.rating;
            state.business.hours = payload.hours;
            state.business.categoryId = payload.category.id;
            state.business.locationId = payload.location.id;
            //initialize it before you set it
            state.business.gallerySet = [];
            payload.gallerySet.map(function(value,key){
                state.business.gallerySet.push(
                    {
                        id: value.id,
                        imageUrl: value.imageUrl,
                        size: value.size,
                        type: value.type

                    });
            })
        },
        setBusinesses(state,payload){
            state.businesses = payload;
        }
    },
    actions: {
        fetchBusiness({commit,state,rootState}){
            commit('setLoading',true);
            axios.get(rootState.serverUrl+'/my/business')
                .then(response => {
                    commit('setLoading',false);
                    //state.business = response.data;
                    commit('setBusiness',response.data);

                })
                .catch(error => {
                    commit('setLoading',false);
                    commit('setAlert',{msg:error.response.data.errors,type:'error'})
                })
        },
        fetchBusinesses({commit,state,rootState}){
            return new Promise(((resolve,reject) => {
                axios.get(rootState.serverUrl+'/business')
                    .then(response => {
                        commit('setBusinesses',response.data);
                        resolve(response);
                    });
            }));

        },
        saveBusiness({commit,state,rootState}){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                if(state.business.id){
                    axios.put(rootState.serverUrl+'/business/'+ state.business.id,state.business)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.errors,type:'error'})

                        });
                }
                else{
                    axios.post(rootState.serverUrl+'/business',state.business)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            state.business.id = response.data.created_id;

                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.errors,type:'error'})

                        });

                }
            }))

        },
        deleteBusinessImage({commit,state,rootState},payload){
            return new Promise(((resolve,reject) => {
                commit('setLoading',true);
                console.log(payload.id);
               axios.delete(rootState.serverUrl+'/business/'+payload.id+"/image")
                   .then(response => {
                       commit('setLoading',false);
                       commit('setAlert',{msg:response.data.message,type:'success'});
                   })
                   .catch(error => {
                       commit('setLoading',false);
                       commit('setAlert',{msg:error.response.data.errors,type:'error'})
                   })

            }))
        }
    },
    getters: {
        getBusiness:state =>{
            return state.business;
        },
        getBusinesses:state => {
            return state.businesses;
        }
    }
}