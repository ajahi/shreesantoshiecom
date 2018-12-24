<template>
    <div class="createPost-container">

        <div class="createPost-main-container">
            <el-form
                    class="form-container"
                    ref="dataForm"
                    :rules="rules"
                    :model="temp"
            >

                <el-col :span="24">

                    <el-form-item label="Name" prop="name">
                        <el-input v-model="temp.name"/>
                        <span style="color: red" v-if="errors.name">
                            <li v-for="item in errors.name">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Email" prop="email">
                        <el-input v-model="temp.email" type="email"/>
                        <span style="color: red" v-if="errors.email">
                            <li v-for="item in errors.email">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Role" prop="role_id">
                        <el-select v-model="temp.role_id" placeholder="please select role">
                            <el-option v-for="item in roles" :key="item.id" :label="item.display_name" :value="item.id"/>
                        </el-select>
                        <span style="color: red" v-if="errors.role_id">
                            <li v-for="item in errors.role_id">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Password" prop="password">
                        <el-input v-model="temp.password" type="password"/>
                        <span style="color: red" v-if="errors.password">
                            <li v-for="item in errors.password">{{item}}</li>
                        </span>
                    </el-form-item>
                    <el-form-item label="Confirm" prop="password_confirmation">
                        <el-input v-model="temp.password_confirmation" type="password" auto-complete="off"/>
                    </el-form-item>
                </el-col>
            </el-form>

            <div slot="footer" class="dialog-footer">
                <el-button type="primary" :loading="apiCall" @click="upload">Save</el-button>
            </div>
        </div>

    </div>
</template>

<script>
    import waves from '../../../directive/waves/index.js'

    export default {
        name: 'User-Detail',
        components: {},
        props: {
            isEdit: {
                type: Boolean,
                default: false
            }
        },

        directives: {
            waves
        },
        filters: {},
        data() {

            var confirmpassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password again'))
                } else if (value !== this.temp.password) {
                    callback(new Error('Password don\'t match!'))
                } else {
                    callback()
                }
            }

            return {

                //required element
                roles: [],
                //tracking variable

                //form element
                temp: {
                    id: undefined,
                    name: '',
                    email: '',
                    role_id: '',
                    password: '',
                    password_confirmation: '',
                    status: 'inactive'
                },

                //errors
                errors: [],

                //form validation rule
                rules: {
                    name: [{ required: true, message: 'name is required', trigger: 'change' }],
                    email: [{ type: 'email', required: true, message: 'email is required', trigger: 'change' }],
                    password: [{ required: true, message: 'password is required'}],
                    password_confirmation: [
                        {
                            validator: confirmpassword,
                            trigger: 'blur'
                        }
                    ],
                    role_id: [{ required: true, message: 'Role is required', trigger: 'change' }]

                },

                //state variable
                apiCall: false

            }
        },
        created() {
            this.$axios.get('/role').then(response => {
                this.roles = response.data.data
            })
            if (this.isEdit) {
                const id = this.$route.params && this.$route.params.id;
                this.fetchData(id);
            }
        },
        methods: {
            fetchData(id) {
                this.$axios.get('/user/' + id).then(response => {
                    this.temp = response.data.data
                    this.temp.password = ''
                })
            },
            upload() {
                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.apiCall = true;
                        if (!this.isEdit) {
                            this.$axios.post('/user/', this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'User Creation completed'
                                })
                                this.$router.push({path: "/user"})
                            }).catch((error) => {
                                this.apiCall = false;
                                this.errors = error.response.data;
                                // for (var key in this.temp) {
                                //     if(error.response.data.hasOwnProperty(key)){
                                //         Message({
                                //             message: error.response.data[key][0] ,
                                //             type: 'error',
                                //             duration: 5 * 1000
                                //         })
                                //     }
                                // }
                            })
                        } else {
                            this.temp['_method'] = 'put'
                            this.$axios.post('/user/' + this.temp.id, this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'User Updated'
                                })
                                this.$router.push({path: "/user"})
                            }).catch((error) => {
                                this.apiCall = false;
                                this.errors = error.response.data;
                            })
                        }
                    }
                })
            }
        },
        watch: {
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    @import "src/styles/mixin.scss";

    .createPost-container {
        position: relative;
        .createPost-main-container {
            padding: 40px 45px 20px 50px;
            .postInfo-container {
                position: relative;
                @include clearfix;
                margin-bottom: 10px;
                .postInfo-container-item {
                    float: left;
                }
            }
            .editor-container {
                min-height: 500px;
                margin: 0 0 30px;
                .editor-upload-btn-container {
                    text-align: right;
                    margin-right: 10px;
                    .editor-upload-btn {
                        display: inline-block;
                    }
                }
            }
        }
        .word-counter {
            width: 40px;
            position: absolute;
            right: -10px;
            top: 0px;
        }
    }
</style>
