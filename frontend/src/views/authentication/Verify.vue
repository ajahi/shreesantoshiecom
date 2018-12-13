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

                <el-form :rules="rules" :model="verifyForm" ref="dataForm" v-show="!userverified" label-position="left" label-width="100px"
                         style='width: 400px; margin-left:50px;'>

                    <el-form-item label="Code" prop="code">
                        <el-input type="text" placeholder="Code" v-model="verifyForm.code"
                                  aria-required="true"></el-input>
                    </el-form-item>



                    <el-form-item>
                        <el-button style="background-color: teal ; color: white" class="float-right"
                                   @click="register()">
                            Verify
                        </el-button>
                    </el-form-item>

                </el-form>
                <el-row type="flex" class="row-bg" v-show='useractive === "inactive"' justify="center">
                    <div style="padding: 10px">Wait for admin approval</div>
                </el-row>

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



            return {
                verifyForm: {
                    email: this.useremail,
                    code: '',


                },
                show: false,
                label: 'Verifying...',
                rules: {
                    code: [{required: true, message: 'code is required', trigger: 'change'}],

                }

            }

        },
        computed: {
            ...mapGetters([
                'app','useractive','useremail','userverified'
            ])
        },

        created: function () {
           if(this.useractive === null || this.useremail === null  ){
               this.$router.push({path: '/register'})
           }else if(this.useractive === "active" && this.userverified === true) {
               this.$router.push({path: '/login'})
           }
        },
        methods: {
            register() {

                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.show = true;
                        this.$axios.post("/verify",{
                            "email":this.useremail,
                            "code" : this.verifyForm.code
                        }).then(response => {
                            const data = response.data.data
                            this.$store.dispatch('SetUser', data).then(() => {
                                this.show = false;
                                Message({
                                    message: "Verification Success",
                                    type: 'success',
                                    duration: 5 * 1000
                                })
                                if(this.useractive === "active"){
                                    this.$router.push({path: '/login'})
                                }
                            }).catch((err) => {
                                console.log(err)
                                this.show = false;

                            })

                        }).catch(error => {
                            Message({
                                message: "Verification error",
                                type: 'error',
                                duration: 5 * 1000
                            })
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