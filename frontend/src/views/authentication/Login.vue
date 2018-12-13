<template>
    <el-row :gutter="20" style="padding: 10px">

        <loading
                :show="show"
                :label="label">
        </loading>

        <el-col :span="10" :offset="7">
            <el-card class="box-card">
                <el-row type="flex" class="row-bg" justify="center"
                        style="border-bottom: 1px solid teal; margin-top: 0px;margin: 20px;">
                    <p class="text-center font-weight-bold"
                       style="/*! border-bottom: 1px solid teal; */ margin-bottom: 6px; margin-top: 0px;font-size: 35px;font-variant: all-petite-caps;color: teal;font-weight: bold;margin-bottom: 5px">
                        <router-link to="/"> {{app.title}}</router-link></p>
                </el-row>

                <el-form :rules="rules" :model="loginForm" ref="dataForm" label-position="left" label-width="100px"
                         style='width: 400px; margin-left:50px;'>
                    <el-form-item label="Email" prop="email">
                        <el-input type="email" placeholder="Email" v-model="loginForm.email"
                                  aria-required="true"></el-input>

                    </el-form-item>
                    <el-form-item label="Password" prop="password">
                        <el-input type="password" placeholder="Password" v-model="loginForm.password"
                                  aria-required="true"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button style="background-color: teal ; color: white" class="float-right" @click="login()">
                            Login
                        </el-button>


                    </el-form-item>

                </el-form>
                <el-row type="flex" class="row-bg" justify="center">

                    <div style="padding: 10px">Not registered yet ?</div>
                    <el-button style="background-color: teal ; color: white" class="float-right" @click="register()">
                        Register
                    </el-button>
                </el-row>
                <el-row v-if="app.socialLogin" style="padding: 20px" type="flex" class="row-bg" justify="center">
                    OR
                </el-row>
                <el-row type="flex" v-if="app.socialLogin" class="row-bg" justify="center">

                    <br>
                    <el-button style="background-color: #3c82f7 ; color: white" class="float-right"
                               @click="openFbLoginDialog()">
                        Facebook
                    </el-button>
                    <el-button style="background-color: red ; color: white" class="float-right"
                               @click="openGoogleLoginDialog()">
                        Google
                    </el-button>
                </el-row>

            </el-card>
        </el-col>
    </el-row>


</template>

<script>
    import loading from 'vue-full-loading';
    import {mapGetters} from 'vuex'
    import Vue from 'vue'
    import GoogleAuth from 'vue-google-auth'

    Vue.use(GoogleAuth, {client_id: '642609790892-0daf0j3o2slljcklnrj95i704gipaj1r.apps.googleusercontent.com'})

    Vue.googleAuth().load()
    Vue.googleAuth().directAccess()

    export default {
        components: {
            loading
        },


        data() {
            return {
                fbSignInParams: {
                    scope: 'email,user_likes',
                    return_scopes: true
                },
                loginForm: {
                    email: '',
                    password: ''
                },
                show: false,
                label: 'Authenticating...',
                rules: {
                    email: [{type: 'email', required: true, message: 'email is required', trigger: 'blur'}],
                    password: [{required: true, message: 'password is required', trigger: 'blur'}],


                }

            }

        },
        computed: {
            ...mapGetters([
                'app',
            ])
        },

        methods: {
            login() {
                this.show = true;

                this.$store.dispatch('Login', this.loginForm).then(response => {

                    if (response.access_token) {
                        this.$store.dispatch('GetUserInfo').then(() => {
                            this.show = false;
                            this.$router.push({path: '/dashboard'})
                        }).catch((err) => {
                            this.show = false;
                        })
                    } else {
                        this.show = false;
                    }
                }).catch((err) => {
                    this.show = false;
                })
            },
            register() {
                this.$router.push('/register')

            },

            openFbLoginDialog() {

                FB.login(function (response) {
                    vm.show = true;

                    if (response.status === 'connected') {
                        FB.api(
                            '/me',
                            'GET',
                            {'fields': ['email', 'first_name', 'last_name', 'middle_name', 'id']},
                            function (FBResponse) {
                                vm.$store.dispatch('Social', {
                                    'provider_name': "facebook",
                                    'response': FBResponse,
                                    'provider_id': FBResponse['id'],
                                    'email': FBResponse['email'],
                                    'name': FBResponse['first_name']+" "+FBResponse['last_name'],
                                }).then(response => {
                                    if (response.access_token) {
                                        vm.$store.dispatch('GetUserInfo').then(() => {
                                            vm.show = false;
                                            vm.$router.push({path: '/dashboard'})
                                        }).catch((err) => {
                                            vm.show = false;
                                        })
                                    } else {
                                        vm.show = false;
                                    }
                                }).catch((err) => {
                                    vm.show = false;
                                })
                            }
                        )
                    }

                }, {scope: 'email'})
            },
            openGoogleLoginDialog() {
                Vue.googleAuth().signIn(function (response) {
                        vm.show = true;

                        console.log(response['w3'])
                        vm.$store.dispatch('Social', {
                            'provider_name': "google",
                            'provider_id': response['w3']['Eea'],
                            'email': response['w3']['U3'],
                            'name': response['w3']['ig'],
                        }).then(response => {
                            if (response.access_token) {
                                vm.$store.dispatch('GetUserInfo').then(() => {
                                    vm.show = false;
                                    vm.$router.push({path: '/dashboard'})
                                }).catch((err) => {
                                    vm.show = false;
                                })
                            } else {
                                vm.show = false;
                            }
                        }).catch((err) => {
                            vm.show = false;
                        })
                    }, function (error) {
                        console.log(error)
                    }
                )
            }

        }
    }

</script>
<style>

    .el-card__header {
        background-color: teal !important;
    }

    .btn {
        background: #42b983;
        color: white;
    }

    h2 {
        color: #42b983;
        text-transform: capitalize;
        font-weight: bolder;

    }

    .login-form {
        width: 340px;
        margin: 50px auto;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .btn {
        font-size: 15px;
        font-weight: bold;
    }

    .g-signin-button {
        /* This is where you control how the button looks. Be creative! */
        display: inline-block;
        padding: 4px 8px;
        border-radius: 3px;
        background-color: #3c82f7;
        color: #fff;
        box-shadow: 0 3px 0 #0f69ff;
    }
</style>