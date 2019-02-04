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
                    <el-form-item label="Name" style="margin-bottom: 40px;" prop="name">
                        <el-input v-model="tempName" type="text"/>
                        <span style="color: red" v-if="errors.name">
                            <li v-for="item in errors.name">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Display Name" prop="display_name">
                        <el-input v-model="temp.display_name" type="name"/>
                        <span style="color: red" v-if="errors.display_name">
                            <li v-for="item in errors.display_name">{{item}}</li>
                        </span>
                    </el-form-item>


                    <el-form-item label="Description" prop="description">
                        <el-input v-model="temp.description" type="text"/>
                        <span style="color: red" v-if="errors.description">
                            <li v-for="item in errors.description">{{item}}</li>
                        </span>
                    </el-form-item>
                </el-col>
            </el-form>

            <div slot="footer" class="dialog-footer">
                <el-button type="primary" :loading="apiCall" @click="upload">Save</el-button>
                <el-button type="success" @click="$router.go(-1)">Cancel</el-button>

            </div>
        </div>

    </div>
</template>

<script>
    import waves from '../../../directive/waves/index.js'

    const capitalize = (s) => {
        if (typeof s !== 'string') return ''
        return s.charAt(0).toUpperCase() + s.slice(1)
    }

    export default {
        name: 'Role-Detail',
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

            return {
                //tracking variable
                tempName: '',

                //form element
                temp: {
                    id: undefined,
                    name: '',
                    display_name: '',
                    description: '',
                },

                //errors
                errors: [],

                //form validation rule
                rules: {
                    name: [{required: true, message: 'Name is required', trigger: 'change'}],
                    display_name: [{required: true, message: 'Display Name is required', trigger: 'change'}],
                    description: [{required: true, message: 'Description is required', trigger: 'change'}],
                },

                //state variable
                apiCall: false

            }
        },
        created() {
            if (this.isEdit) {
                const id = this.$route.params && this.$route.params.id;
                this.fetchData(id);
            }
        },
        methods: {
            fetchData(id) {
                this.$axios.get('/permission/' + id).then(response => {
                    this.tempName = response.data.data.name;
                    this.temp = response.data.data
                })
            },
            upload() {
                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.apiCall = true;
                        if (!this.isEdit) {
                            this.$axios.post('/permission/', this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Permission Creation completed'
                                })
                                this.$router.push({path: "/permission"})
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
                            this.$axios.post('/permission/' + this.temp.id, this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Permission Updated'
                                })
                                this.$router.push({path: "/permission"})
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
            tempName: function (val) {
                this.temp.name = val;
                if (!this.isEdit) {
                    this.temp.display_name = capitalize(val);
                    this.temp.description = "This is " + capitalize(val) + " account";
                }

            },
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
