import axios from 'axios'

export default {
    state: {
        location: {
            id: '',
            city: '',
            state: '',
            zipcode: '',
            buildingNo: '',
            streetNumber: '',
            latitude: '',
            longtitude: '',

        },
        locations: []
    },
    mutations: {
        setLocation(state,payload){
            state.location.id = payload.id;
            state.location.city = payload.city;
            state.location.state = payload.state;
            state.location.zipcode = payload.zipcode;
            state.location.buildingNo = payload.buildingNo;
            state.location.streetName = payload.streetName;
            state.location.latitude = payload.latitude;
            state.location.longtitude = payload.longtitude;
        },
        setLocations(state,payload){
            state.locations = payload;
        },
        setLocationId(state,payload){
            state.location.id = payload;
        }

    },
    actions: {
        fetchLocations({commit,state,rootState}){
          commit('setLoading',true);
          axios.get(rootState.serverUrl+'/location')
              .then(response => {
                  commit('setLocations',response.data);
                  commit('setLoading',false);
              })
              .catch(error => {
                  commit('setLoading',false);
                  commit('setAlert',{msg:error.response.data.errors,type:'error'})
              })
        },
        saveLocation({commit,state,rootState},payload){
            return new Promise((resolve,reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.post(rootState.serverUrl+'/location/'+payload.id, payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            app.dispatch('fetchLocations');
                            resolve(response);
                        })
                        .catch(error => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.errors,type:'error'});
                            reject(error);
                        });
                }
                else{
                    axios.post(rootState.serverUrl+'/location/', payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            //setting id for newly created
                            commit('setLocationId',response.data.created_id);
                            app.dispatch('fetchLocations');
                            resolve(response);
                        })
                        .catch(error=> {
                            commit('setLoading',false);
                            commit('setAlert',{msg:error.response.data.errors,type:'error'})
                            reject(error);
                        })
                }

            })


        },
        deleteLocation({commit,state,rootState},payload){
            commit('setLoading',true);
            const app = this;
            axios.delete(rootState.serverUrl+'/location/'+payload)
                .then(response => {
                    commit('setLoading',false);
                    commit('setAlert',{msg:response.data.message,type:'success'})
                    app.dispatch('fetchLocations');
                })
                .catch(error => {
                    commit('setLoading',false);
                    commit('setAlert',{msg:error.response.data.errors,type:'error'});
                });

        },
        setLocation({commit,state},payload){
            commit('setLocation',payload);
        }

    },
    getters: {
        getLocation:state => {
            return state.location
        },
        getLocations:state => {
            return state.locations;
        }
    }
}