import axios from 'axios';

export default {
    state: {
        members: [],
        member: {},
        clubDesignation: {}
    },
    mutations:{
        setMember(state,payload){
            state.member = payload
            if(payload.club) {
                state.member.clubId = payload.club.id;
            }
        },
        setMembers(state,members){
            state.members = members;
        },
        setMemberId(state,payload){
            state.member.id = payload
        },
        setClubDesignation(state,payload){
            state.clubDesignation = payload
        },
        setClubDesignationId(state,payload){
            state.clubDesignation.id = payload
        },
        setMemberImage(state,payload){
            state.member.imageUrl = payload;
        }

    },
    actions: {
        fetchMember({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/users/'+payload)
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setMember',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchMembers({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/users')
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setMembers',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchClubDesignation({commit,state},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/users/'+payload+'/designation')
                    .then(response =>{
                        commit('setLoading',false)
                        if(response.data !== null) {
                            commit('setClubDesignation', response.data)
                        }
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        reject(error)
                    })

            }))

        },
        saveMember({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put('/users/'+payload.id,payload)
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
                    axios.post('/users',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setMemberId',response.data.created_id);
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
        saveClubDesignation({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                if(payload.id){
                    axios.put('/users/'+state.member.id +'/designation/'+payload.id,payload)
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
                    axios.post('/users/'+state.member.id +'/designation',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setClubDesignationId',response.data.created_id);
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
        setMember({commit,state},payload){
            commit('setMember',payload);
        },
        setMemberImage({commit,state},payload){
            commit('setMemberImage',payload);
        },
        clearMember({commit}){
            commit('setMember',{})
        },
        clearClubDesignation({commit}){
            commit('setClubDesignation',{})
        }
    },
    getters: {
        getMember:state => {
            return state.member;
        },
        getMembers:state => {
            return state.members;
        },
        getClubDesignation:state => {
            return state.clubDesignation;
        }
    }
}
