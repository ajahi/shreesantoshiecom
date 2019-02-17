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
                    <el-form-item label="Title" style="margin-bottom: 40px;" prop="title">
                        <el-input v-model="temp.title" type="text"/>
                        <span style="color: red" v-if="errors.title">
                            <li v-for="item in errors.title">{{item}}</li>
                        </span>
                    </el-form-item>


                    <el-form-item label="Description" prop="description">
                        <el-input v-model="temp.description" type="text"/>
                        <span style="color: red" v-if="errors.description">
                            <li v-for="item in errors.description">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item v-if="isEdit" label="Position" style="margin-bottom: 40px;" prop="position">
                        <el-input v-model="temp.position" type="text"/>
                        <span style="color: red" v-if="errors.position">
                            <li v-for="item in errors.position">{{item}}</li>
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



    export default {
        name: 'Category-Detail',
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

                //form element
                temp: {
                    id: undefined,
                    title: '',
                    description: '',
                    position: null
                },

                //errors
                errors: [],

                //form validation rule
                rules: {
                    title: [{required: true, message: 'Name is required'}],
                    description: [{required: true, message: 'Description is required'}],
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
                this.$axios.get('/category/' + id).then(response => {
                    this.temp = response.data.data
                })
            },
            upload() {
                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.apiCall = true;
                        if (!this.isEdit) {
                            this.$axios.post('/category', this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Category Creation completed'
                                })
                                this.$router.push({path: "/category"})
                            }).catch((error) => {
                                this.apiCall = false;
                                this.errors = error.response.data;
                            })
                        } else {
                            this.temp['_method'] = 'put'
                            this.$axios.post('/category/' + this.temp.id, this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Category Updated'
                                })
                                this.$router.push({path: "/category"})
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
