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

                    <el-form-item label="Title" prop="title">
                        <el-input v-model="temp.title"/>
                        <span style="color: red" v-if="errors.title">
                            <li v-for="item in errors.title">{{item}}</li>
                        </span>
                    </el-form-item>


                    <el-form-item label="Description" prop="description">
                        <div class="editor-container">
                            <Tinymce :height=400 ref="editor" v-model="temp.description"/>
                        </div>
                        <span style="color: red" v-if="errors.description">
                            <li v-for="item in errors.description">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Icon" prop="icon">
                        <el-input v-model="temp.icon"/>
                        <span style="color: red" v-if="errors.icon">
                            <li v-for="item in errors.icon">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Status" prop="status">
                        <el-select class="filter-item" v-model="temp.status" placeholder="Please select">
                            <el-option v-for="item in  statusOptions" :key="item.key" :label="item.label"
                                       :value="item.key">
                            </el-option>
                        </el-select>
                    </el-form-item>


                    <el-form-item label="Category" prop="category_id">
                        <el-select v-model="temp.category_id" placeholder="please select role">
                            <el-option v-for="item in  categories" :key="item.id" :label="item.title" :value="item.id">
                            </el-option>
                        </el-select>
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
    import Tinymce from '../../../components/Tinymce'

    export default {
        name: 'Post-Detail',
        components: {Tinymce},
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

                //required element
                categories: [],
                //tracking variable

                //form element
                temp: {
                    id: undefined,
                    title: '',
                    description: '',
                    category_id: null,
                    icon: null,
                    status: null

                },

                //errors
                errors: [],

                //form validation rule
                rules: {
                    title: [{required: true, message: 'title is required', trigger: 'change'}],
                    description: [{required: true, message: 'description is required', trigger: 'change'}],
                    icon: [{required: true, message: 'icon is required', trigger: 'change'}],
                    category_id: [{required: true, message: 'Category is required', trigger: 'change'}],
                    status: [{required: true, message: 'Status is required', trigger: 'change'}]

                },

                //state variable
                apiCall: false,

                statusOptions: [{label: 'Published', key: 'published'}, {label: 'Draft', key: 'draft'}],


            }
        },
        created() {
            this.$axios.get('/category').then(response => {
                this.categories = response.data.data
            })
            if (this.isEdit) {
                const id = this.$route.params && this.$route.params.id;
                this.fetchData(id);
            }
        },
        methods: {
            fetchData(id) {
                this.$axios.get('/post/' + id).then(response => {
                    this.temp = response.data.data
                })
            },
            upload() {
                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.apiCall = true;
                        if (!this.isEdit) {
                            this.$axios.post('/post/', this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Post Creation completed'
                                })
                                this.$router.push({path: "/post"})
                            }).catch((error) => {
                                this.apiCall = false;
                                this.errors = error.response.data;
                            })
                        } else {
                            this.temp['_method'] = 'put'
                            this.$axios.post('/post/' + this.temp.id, this.temp).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Post Updated'
                                })
                                this.$router.push({path: "/post"})
                            }).catch((error) => {
                                this.apiCall = false;
                                this.errors = error.response.data;
                            })
                        }
                    }
                })
            }
        },
        watch: {}
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
