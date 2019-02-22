import axios from 'axios';

export default {
    state: {
        clubs: [],
        club: {},
        years:[],
        year:{}
    },
    mutations:{
        setClub(state,payload){
            state.club = payload
        },
        setClubs(state,clubs){
            state.clubs = clubs;
        },
        setDefaultYear(state,year){
            state.club.year = year;
        },
        setClubId(state,payload){
            state.club.id = payload
        },
        setClubLogo(state,payload){
            state.club.logo = payload
        },
        setYear(state,payload){
            state.year = payload
        },
        setYears(state,payload){
            state.years = payload
        },
        setYearId(state,payload){
            state.year.id = payload
        }

    },
    actions: {
        fetchClub({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/club/'+payload)
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setClub',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchClubs({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/club')
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setClubs',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchDefaultYear({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/club/'+payload+'/default-year')
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setDefaultYear',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error,type:'error'})
                        reject(error)
                    })

            }))

        },
        saveClub({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put('/club/'+payload.id,payload)
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
                    axios.post('/club',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setClubId',response.data.created_id);
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
        setClub({commit,state},payload){
            commit('setClub',payload);
        },
        setClubLogo({commit,state},payload){
            commit('setClubLogo',payload);
        },
        clearClub({commit}){
            commit('setClub',{});
        },
        fetchYear({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/club/'+state.club.id + '/year/' + payload)
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setYear',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        console.log(error);
                        commit('setLoading',false);
                        commit('setAlert',{msg:error,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchYears({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/club/'+payload+'/year')
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setYears',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        saveYear({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put('/club/'+state.club.id+'/year/'+payload.id,payload)
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
                    axios.post('/club/'+state.club.id+'/year',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setYearId',response.data.created_id);
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
        deleteYear({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.delete('/club/'+state.club.id + '/year/' + payload)
                    .then(response =>{
                        commit('setLoading',false)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error,type:'error'})
                        reject(error)
                    })

            }))

        },
        setYear({commit,state},payload){
            commit('setYear',payload);
        },
        setYears({commit,state},payload){
            commit('setYears',payload);
        },
        clearYear({commit}){
            commit('setYear',{});
        },
    },
    getters: {
        getClub:state => {
            return state.club;
        },
        getClubs:state => {
            return state.clubs;
        },
        getYear:state => {
            return state.year;
        },
        getYears:state => {
            return state.years;
        }
    }
}
