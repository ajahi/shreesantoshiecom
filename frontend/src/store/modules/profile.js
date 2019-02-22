import axios from 'axios'

export default {
    state: {
        profile: {
            id: '',
            email: '',
            username: '',
            providerId: '',
            provider:'',
            role: '',
            firstName: '',
            lastName: '',
            gender: '',
            imageUrl: '',
            temporaryAddress:'',
            permanentAddress: '',
            mobileNumber: '',
            occupation: '',
            education: '',
            dob:'',
            fatherName:'',
            motherName: '',
            citizenshipNumber: '',
            roleId:'',
            bloodGroup:''
        }
    },
    mutations: {
        setProfile(state, payload) {
            state.profile.id = payload.id;
            state.profile.email = payload.email;
            state.profile.username = payload.username;
            state.profile.providerId = payload.providerId;
            state.profile.provider = payload.provider;
            state.profile.role = payload.role;
            state.profile.roleId =payload.roleId;
            state.profile.firstName = payload.firstName;
            state.profile.lastName = payload.lastName;
            state.profile.gender = payload.gender;
            state.profile.bloodGroup = payload.bloodGroup;
            state.profile.imageUrl = payload.imageUrl;
            state.profile.temporaryAddress = payload.temporaryAddress;
            state.profile.permanentAddress = payload.permanentAddress;
            state.profile.mobileNumber = payload.mobileNumber;
            state.profile.occupation = payload.occupation;
            state.profile.education = payload.education;
            state.profile.dob = payload.dob;
            state.profile.fatherName = payload.fatherName;
            state.profile.motherName = payload.motherName;
            state.profile.citizenshipNumber = payload.citizenshipNumber;
        }

    },
    actions: {

        getMe({commit, state, rootState}) {
            commit('setLoading', true);
            axios.get('/users/me')
                .then(response => {
                    commit('setProfile', {
                        'id': response.data.id,
                        'email': response.data.email,
                        'username': response.data.username,
                        'providerId': response.data.providerId,
                        'role': response.data.role.name,
                        'roleId': response.data.role.id,
                        'firstName': response.data.firstName,
                        'lastName': response.data.lastName,
                        'gender': response.data.gender,
                        'bloodGroup': response.data.bloodGroup,
                        'imageUrl': response.data.imageUrl,
                        'temporaryAddress': response.data.temporaryAddress,
                        'permanentAddress': response.data.permanentAddress,
                        'mobileNumber': response.data.mobileNumber,
                        'occupation': response.data.occupation,
                        'education': response.data.education,
                        'dob': response.data.dob,
                        'fatherName': response.data.fatherName,
                        'motherName': response.data.motherName,
                        'citizenshipNumber': response.data.citizenshipNumber

                    });

                    commit('setLoading',false)

                })
                .catch(error => {
                    console.log(error);
                    commit('setLoading',false);
                    commit('setAlert',{msg:error.response.data.message,type:'error'})
                })

        },
        saveMe({commit,state,rootState},payload){
            commit('setLoading',true);
            axios.post('/users/'+state.profile.id, state.profile)
                .then(response => {
                    commit('setLoading',false);
                    commit('setAlert',{msg:response.data.message,type:'success'})
                })
                .catch(error=> {
                commit('setLoading',false);
                commit('setAlert',{msg:error.response.data.errors,type:'error'})
            })
        },


    },
    getters: {
        getProfile:state =>{
            return state.profile
        }
    }
}
