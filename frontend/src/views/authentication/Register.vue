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
                        {{app.title}}</p>
                </el-row>

                <el-form :rules="rules" :model="registerForm" ref="dataForm" label-position="left" label-width="100px"
                         style='width: 400px; margin-left:50px;'>

                    <el-form-item label="Name" prop="name">
                        <el-input type="text" placeholder="Name" v-model="registerForm.name"
                                  aria-required="true"></el-input>
                    </el-form-item>

                    <el-form-item label="Email" prop="email">
                        <el-input type="email" placeholder="Email" v-model="registerForm.email"
                                  aria-required="true"></el-input>

                    </el-form-item>

                    <el-form-item label="Password" prop="password">
                        <el-input type="password" placeholder="Password" v-model="registerForm.password"
                                  aria-required="true"></el-input>
                    </el-form-item>

                    <el-form-item label="Confirm" prop="password_confirmation">
                        <el-input type="password" placeholder="Password" v-model="registerForm.password_confirmation"
                                  aria-required="true"></el-input>
                    </el-form-item>

                    <el-form-item>
                        <el-button style="background-color: teal ; color: white" class="float-right"
                                   @click="register()">
                            Register
                        </el-button>
                    </el-form-item>

                </el-form>
                <el-row type="flex" class="row-bg" justify="center">
                    <div style="padding: 10px">Already registered ?</div>
                    <el-button style="background-color: teal ; color: white" class="float-right" @click="login()">
                        Login
                    </el-button>
                </el-row>
            </el-card>
        </el-col>
    </el-row>


</template>

<script>
    import loading from 'vue-full-loading';
    import {mapGetters} from 'vuex'
    import {Message} from 'element-ui'

    export default {
        components: {
            loading
        },

        data() {


            var confirmpassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password again'));
                } else if (value !== this.registerForm.password) {
                    callback(new Error('Two inputs don\'t match!'));
                } else {
                    callback();
                }
            };

            return {
                registerForm: {
                    email: '',
                    password: '',
                    name: '',
                    password_confirmation: ''

                },
                show: false,
                label: 'Registering...',
                rules: {
                    name: [{required: true, message: 'name is required', trigger: 'change'}],
                    email: [{type: 'email', required: true, message: 'email is required', trigger: 'blur'}],
                    password: [{required: true, message: 'password is required', trigger: 'blur'}],
                    password_confirmation: [
                        {
                            validator: confirmpassword,
                            trigger: 'blur'
                        }
                    ]

                }

            }

        },
        computed: {
            ...mapGetters([
                'app',
            ])
        },

        methods: {
            register() {

                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.show = true;
                        this.$axios.post("/signup", this.registerForm).then(response => {
                            const data = response.data.data
                            this.$store.dispatch('SetUser', data).then(() => {
                                this.show = false;
                                if(this.$store.getters.app.authentication === "loose"){
                                    Message({
                                        message: "Login using credentials",
                                        type: 'success',
                                        duration: 5 * 1000
                                    })
                                    this.$router.push({path: '/login'})
                                    resolve();

                                }else if (this.$store.getters.app.authentication === "code"){
                                    Message({
                                        message: "Check Your email for code",
                                        type: 'success',
                                        duration: 5 * 1000
                                    })
                                    this.$router.push({path: '/verify'})
                                    resolve();

                                }
                                else if (this.$store.getters.app.authentication === "admin"){
                                    Message({
                                        message: "Wait for approval",
                                        type: 'success',
                                        duration: 5 * 1000
                                    })
                                    this.$router.push({path: '/verify'})
                                    resolve();

                                }else if (this.$store.getters.app.authentication === "hybrid"){
                                    Message({
                                        message: "Check Your email for code Wait for approval",
                                        type: 'success',
                                        duration: 5 * 1000
                                    })
                                    this.$router.push({path: '/verify'})
                                    resolve();

                                }

                                this.$router.push({path: '/verify'})
                            }).catch((err) => {
                                console.log(err)
                                this.show = false;

                            })

                        }).catch(error => {

                            for (var key in this.registerForm) {
                                if(error.response.data.errors.hasOwnProperty(key)){
                                    Message({
                                        message: error.response.data.errors[key][0] ,
                                        type: 'error',
                                        duration: 5 * 1000
                                    })
                                    vm.show = false;

                                }
                            }
                            // console.log(error.response.data.errors)
                            // if(error.response.data.errors.email){
                            //     Message({
                            //         message: error.response.data.errors.email[0] ,
                            //         type: 'error',
                            //         duration: 5 * 1000
                            //     })
                            // }
                            //
                            // if(error.response.data.errors.password){
                            //     Message({
                            //         message: error.response.data.errors.password[0] ,
                            //         type: 'error',
                            //         duration: 5 * 1000
                            //     })
                            // }
                            //
                            // if(error.response.data.errors.name){
                            //     Message({
                            //         message: error.response.data.errors.name[0] ,
                            //         type: 'error',
                            //         duration: 5 * 1000
                            //     })
                            // }

                            this.show = false;
                        })

                    }
                })


            },
            login() {

                this.$router.push('/login')
            },
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
</style>