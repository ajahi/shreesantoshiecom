import axios from 'axios';

export default {
    state: {
        calendars: [],
        calendar: {},
    },
    mutations:{
        setCalendar(state,payload){
            state.calendar = payload

        },
        setCalendars(state,calendars){
            state.calendars = calendars;
        },
        setCalendarId(state,payload){
            state.calendar.id = payload
        },

    },
    actions: {
        fetchCalendar({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/calendar/'+payload)
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setCalendar',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        fetchCalendars({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.get('/calendar')
                    .then(response =>{
                        commit('setLoading',false)
                        commit('setCalendars',response.data)
                        resolve(response)

                    })
                    .catch(error => {
                        commit('setLoading',false);
                        commit('setAlert',{msg:error.response.data.errors,type:'error'})
                        reject(error)
                    })

            }))

        },
        saveCalendar({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {

                commit('setLoading',true);
                const app = this;
                if(payload.id){
                    axios.put('/calendar/'+payload.id,payload)
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
                    axios.post('/calendar',payload)
                        .then(response => {
                            commit('setLoading',false);
                            commit('setAlert',{msg:response.data.message,type:'success'});
                            commit('setCalendarId',response.data.created_id);
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

        deleteCalendar({commit,state,rootState},payload){
            return new Promise(((resolve, reject) => {
                commit('setLoading',true);
                axios.delete('/calendar/'+payload)
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
        setCalendar({commit,state},payload){
            commit('setCalendar',payload);
        },
        clearCalendar({commit}){
            commit('setCalendar',{})
        },

    },
    getters: {
        getCalendar:state => {
            return state.calendar;
        },
        getCalendars:state => {
            return state.calendars;
        }
    }
}
