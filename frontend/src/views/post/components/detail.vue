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

                    <div class="postInfo-container">
                        <el-row>
                            <el-col :span="6">
                                <el-form-item class="postInfo-container-item" label="Icon" prop="icon">
                                    <el-input v-model="temp.icon"/>
                                    <span style="color: red" v-if="errors.icon">
                            <li v-for="item in errors.icon">{{item}}</li>
                        </span>
                                </el-form-item>
                            </el-col>

                            <el-col :span="6">
                                <el-form-item class="postInfo-container-item" label="Status" prop="status">
                                    <el-select class="filter-item" v-model="temp.status" placeholder="Please select">
                                        <el-option v-for="item in  statusOptions" :key="item.key" :label="item.label"
                                                   :value="item.key">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>

                            <el-col :span="6">
                                <el-form-item class="postInfo-container-item" label="Category" prop="category_id">
                                    <el-select class="filter-item" v-model="temp.category_id"
                                               placeholder="please select role">
                                        <el-option v-for="item in  categories" :key="item.id" :label="item.title"
                                                   :value="item.id">
                                        </el-option>
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </div>
                    <el-form-item label="Description" prop="description">
                        <div class="editor-container">
                            <Tinymce :height=400 ref="editor" v-model="temp.description"/>
                        </div>
                        <span style="color: red" v-if="errors.description">
                            <li v-for="item in errors.description">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Featured Image" prop="featured">
                        <img :src="temp.featured" height="200px">
                        <br>
                        <input type="file" id="file" ref="featured" v-on:change="handleFileUpload()"/>
                    </el-form-item>

                    <el-form-item label="Gallery" prop="gallery">

                        <el-upload
                                action="http://localhost:8000/api/post/uploads"
                                drag
                                multiple
                                :limit="3"
                                :headers="headerInfo"
                                :on-preview="handlePictureCardPreview"
                                :on-remove="handleRemove"
                                :data="uploadData"
                                name="file"
                                :file-list="fileList"
                                :before-upload="setUploadData">


                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">Drop file here or <em>click to upload</em></div>
                            <div class="el-upload__tip" slot="tip">jpg/png files with a size less than 500kb</div>
                        </el-upload>
                        <el-dialog :visible.sync="dialogVisible">
                            <img width="100%" :src="dialogImageUrl" alt="">
                        </el-dialog>

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
    import Vue from 'vue'

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

                featured: null,

                fileList: [],


                //form element
                temp: {
                    id: undefined,
                    title: '',
                    description: '',
                    category_id: null,
                    icon: null,
                    status: null,
                    featured: null,
                    gallery: []

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
                uploadData: {},
                dialogImageUrl: '',
                dialogVisible: false,
                headerInfo: {
                    'Authorization': `Bearer ${Vue.auth.getToken()}`,
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
                    this.fileList = response.data.data.gallery
                })
            },

            handleFileUpload() {
                this.featured = this.$refs.featured.files[0];
            },
            upload() {
                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.apiCall = true;
                        if (!this.isEdit) {
                            var formData = new FormData();

                            formData.append('title', this.temp.title);
                            formData.append('description', this.temp.description);
                            formData.append('category_id', this.temp.category_id);
                            formData.append('status', this.temp.status);

                            formData.append('icon', this.temp.icon);

                            if (this.featured) {
                                formData.append('featured', this.featured);
                            }
                            this.$axios.post('/post/', formData).then(response => {
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

                            var formData = new FormData();
                            formData.append('_method', "put");

                            formData.append('title', this.temp.title);
                            formData.append('description', this.temp.description);
                            formData.append('category_id', this.temp.category_id);
                            formData.append('status', this.temp.status);

                            formData.append('icon', this.temp.icon);

                            if (this.featured) {
                                formData.append('featured', this.featured);
                            }
                            this.$axios.post('/post/' + this.temp.id, formData).then(response => {
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
            },

        //    gallery related function
            setUploadData(file) {
                return new Promise(resolve => {
                    this.uploadData = {
                        post: this.temp.id,
                    }

                    this.$nextTick(() => {
                        resolve(file)
                    })
                })
            },

            handlePictureCardPreview(file) {
                this.dialogImageUrl = file.url;
                this.dialogVisible = true;

            },

            handleRemove(file) {
                this.$axios.get("/media/" + this.temp.id + "/" + file.id).then(response => {
                    this.fileList = response.data.data;
                    this.temp.media = response.data.data;


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
