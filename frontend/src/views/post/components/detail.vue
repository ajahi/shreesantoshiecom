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

                    <el-form-item prop="title">
                        <el-input placeholder="Title" v-model="temptitle">
                            <template slot="prepend">Title</template>
                        </el-input>
                        <span style="color: red" v-if="errors.title">
                            <li v-for="item in errors.title">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-row>
                        <el-col :xl="15" :lg="15">
                            <el-form-item label="Description" prop="description">
                                <div class="editor-container">
                                    <Tinymce :height=400 ref="editor" v-model="temp.description"/>
                                </div>
                                <span style="color: red" v-if="errors.description">
                            <li v-for="item in errors.description">{{item}}</li>
                        </span>
                            </el-form-item>

                            <el-form-item label="Additional property" style="padding-left:.5rem;">
                                <br>
                                <div>
                                    <el-row :gutter="20">


                                        <p style="padding: 30px" v-for="(value,propertyName) in temp.attributes">
                                            <el-button v-if="userrole.name === 'super_admin'" type="danger"
                                                       @click="remove(propertyName)">X
                                            </el-button>

                                            <el-input v-if="userrole.name === 'super_admin'" style="width: 100px"
                                                      v-model="propertyName"></el-input>
                                            <label v-else>{{propertyName}}</label>

                                            :
                                            <el-select v-if="userrole.name === 'super_admin'" style="width: 100px"
                                                       v-model="temp.attributes[propertyName]['type']"
                                                       placeholder="Select type">
                                                <el-option
                                                        label="Editor"
                                                        value="editor">
                                                </el-option>
                                                <el-option
                                                        label="Text"
                                                        value="text">
                                                </el-option>
                                                <el-option
                                                        label="Media"
                                                        value="media">
                                                </el-option>
                                            </el-select>
                                            <Tinymce :height=400
                                                     v-if="temp.attributes[propertyName]['type'] === 'editor'"
                                                     v-model="temp.attributes[propertyName]['value']"/>
                                            <el-input style="width: 40%"
                                                      v-if="temp.attributes[propertyName]['type'] === 'text'"
                                                      v-model="temp.attributes[propertyName]['value']"></el-input>
                                            <a style="width: 40%" class="btn"
                                               v-if="temp.attributes[propertyName]['type'] === 'media'"
                                               :href="temp.attributes[propertyName]['url'] | CompleteUrl(base_url) ">{{propertyName}}</a>

                                        </p>
                                    </el-row>
                                </div>
                                <el-row v-if="userrole.name === 'super_admin'" :gutter="20">
                                    <el-col :xl="5" :lg="5" :md="5">
                                        <el-input v-model="Aproperty" placeholder="Property" type="text"/>
                                    </el-col>
                                    <el-col :xl="5" :lg="5" :md="5">
                                        <el-input v-if="Atype === 'text'" v-model="Avalue" placeholder="Value"
                                                  type="text"/>
                                        <Tinymce :height=400 v-if="Atype === 'editor'" v-model="Avalue"/>
                                        <input type="file" id="uploadFile" v-if="Atype === 'media'" ref="file1"
                                               v-on:change="handleMediaUpload()"/>

                                    </el-col>
                                    <el-col :xl="5" :lg="5" :md="5">
                                        <el-select v-model="Atype" placeholder="Select type">
                                            <el-option
                                                    label="Editor"
                                                    value="editor">
                                            </el-option>
                                            <el-option
                                                    label="Text"
                                                    value="text">
                                            </el-option>
                                            <el-option
                                                    label="Media"
                                                    value="media">
                                            </el-option>
                                        </el-select>
                                    </el-col>
                                    <el-col :xl="5" :lg="5" :md="5">
                                        <el-button @click="add(Aproperty,Avalue,Atype)">Add</el-button>
                                    </el-col>
                                </el-row>
                            </el-form-item>

                        </el-col>
                        <el-col :xl="8" :lg="8" class="side-bar">

                            <el-form-item class="postInfo-container-item" label="Status" prop="status">
                                <br>
                                <el-select class="filter-item" v-model="temp.status" placeholder="Please select">
                                    <el-option v-for="item in  statusOptions" :key="item.key" :label="item.label"
                                               :value="item.key">
                                    </el-option>
                                </el-select>
                            </el-form-item>
                            <el-form-item class="postInfo-container-item" label="Slug" prop="slug">
                                <br>
                                <el-input style="width: 64%" v-model="temp.slug"/>
                                <span style="color: red" v-if="errors.slug">
                            <li v-for="item in errors.slug">{{item}}</li>
                        </span>
                            </el-form-item>

                            <el-form-item class="postInfo-container-item" label="Category" prop="category_id">
                                <br>
                                <el-select class="filter-item" v-model="temp.category_id"
                                           placeholder="please select role">
                                    <el-option v-for="item in  categories" :key="item.id" :label="item.title"
                                               :value="item.id">
                                    </el-option>
                                </el-select>
                            </el-form-item>


                            <el-form-item class="postInfo-container-item" label="Icon" prop="icon">
                                <br>
                                <el-input style="width: 64%" v-model="temp.icon"/>
                                <span style="color: red" v-if="errors.icon">
                            <li v-for="item in errors.icon">{{item}}</li>
                        </span>
                            </el-form-item>

                            <el-form-item label="Featured Image" prop="featured">
                                <br>
                                <img style="max-width: 100%;height: auto" :src="temp.featured" height="200px">
                                <br>
                                <input type="file" id="file" ref="featured" v-on:change="handleFileUpload()"/>
                            </el-form-item>

                            <div style="text-align: center;">
                            <el-button style="width: 50%; margin-bottom: 1rem;" type="primary" :loading="apiCall" @click="upload">Save
                            </el-button>
                            </div>



                        </el-col>
                    </el-row>


                </el-col>

            </el-form>

            <br>

            <div style=" box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);padding: 30px; "
                 v-if="isEdit" label="Gallery" prop="gallery">

                <h1>Gallery</h1>
                <el-upload
                        :action="image_url"

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

            </div>
        </div>

    </div>
</template>

<script>
    import waves from '../../../directive/waves/index.js'
    import Tinymce from '../../../components/Tinymce'
    import Vue from 'vue'
    import {mapGetters} from 'vuex'

    export default {
        name: 'Post-Detail',
        components: {Tinymce},
        props: {
            isEdit: {
                type: Boolean,
                default: false
            },
            redirect: {
                type: String,
                default: null
            }
        },

        directives: {
            waves
        },
        computed: {
            ...mapGetters([
                'userrole'
            ]),
            image_url: function () {
                // `this` points to the vm instance
                return process.env.BASE_API + 'post/uploads'
            }

        },
        filters: {},
        data() {


            return {
                //attribute related variable
                Aproperty: '',
                Avalue: null,
                Atype: 'text',
                Aurl: null,
                file1: null,


                //required element
                categories: [],
                //tracking variable

                featured: null,

                fileList: [],


                //form element
                temptitle:null,
                temp: {
                    id: undefined,
                    title: '',
                    description: '',
                    category_id: null,
                    icon: null,
                    status: 'published',
                    featured: null,
                    gallery: [],
                    attributes: {},
                    slug:''

                },

                //errors
                errors: [],

                //form validation rule
                rules: {
                    title: [{required: true, message: 'title is required', trigger: 'change'}],
                    description: [{required: true, message: 'description is required', trigger: 'change'}],
                    category_id: [{required: true, message: 'Category is required', trigger: 'change'}],
                    status: [{required: true, message: 'Status is required', trigger: 'change'}],
                    slug: [{required: true, message: 'slug is required', trigger: 'blur'}],


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

                redirect: null


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
                    this.temptitle = response.data.data.title

                    this.fileList = response.data.data.gallery
                    if (this.temp.attributes === null) {
                        this.temp.attributes = {}
                    }
                })
            },
            //generate slug from title
            sanitizeTitle: function (title) {
                var slug = "";
                // Change to lower case

                var titleLower = title.toLowerCase();
                // Letter "e"
                slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
                // Letter "a"
                slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
                // Letter "o"
                slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
                // Letter "u"
                slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
                // Letter "d"

                slug = slug.replace(/đ/gi, 'd');
                // Trim the last whitespace
                slug = slug.replace(/\s*$/g, '');
                // Change whitespace to "-"
                slug = slug.replace(/\s+/g, '-');
                slug = slug.replace('/', '-');

                return slug;
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
                            formData.append('slug', this.temp.slug);

                            formData.append('description', this.temp.description);
                            formData.append('category_id', this.temp.category_id);
                            formData.append('status', this.temp.status);

                            formData.append('icon', this.temp.icon);
                            formData.append('attributes', JSON.stringify(this.temp.attributes));


                            if (this.featured) {
                                formData.append('featured', this.featured);
                            }
                            this.$axios.post('/post', formData).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Post Creation completed'
                                })
                                if (this.redirect) {
                                    this.$router.push({path: "/admin/" + this.$route.query.redirect})

                                } else {
                                    this.$router.push({path: "/post"})

                                }
                            }).catch((error) => {
                                this.apiCall = false;
                                this.errors = error.response.data;
                            })
                        } else {

                            var formData = new FormData();
                            formData.append('_method', "put");

                            formData.append('title', this.temp.title);
                            formData.append('slug', this.temp.slug);

                            formData.append('description', this.temp.description);
                            formData.append('category_id', this.temp.category_id);
                            formData.append('status', this.temp.status);

                            formData.append('icon', this.temp.icon);
                            formData.append('attributes', JSON.stringify(this.temp.attributes));

                            if (this.featured) {
                                formData.append('featured', this.featured);
                            }
                            this.$axios.post('/post/' + this.temp.id, formData).then(response => {
                                this.$message({
                                    type: 'success',
                                    message: 'Post Updated'
                                })

                                if (this.redirect) {
                                    this.$router.push({path: "/admin/" + this.$route.query.redirect})

                                } else {
                                    this.$router.push({path: "/post"})

                                }

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
            },

            handleMediaUpload() {
                this.file1 = this.$refs.file1.files[0];
                if (this.file1) {
                    var formData = new FormData();

                    formData.append('file', this.file1);
                    this.$axios.post('/site/upload', formData).then(response => {

                        this.Avalue = response.data.file;
                        this.Aurl = response.data.url;

                        this.$message({
                            type: 'success',
                            message: 'File Uploaded'
                        })
                    }).catch((error) => {

                    })
                }


            },

            remove(property) {
                if (this.temp.attributes[property].type === 'media') {
                    this.$axios.post('/site/media/delete', {
                        file: this.temp.attributes[property].type.value
                    }).then(response => {
                        Vue.delete(this.temp.attributes, property);

                        this.$message({
                            type: 'success',
                            message: 'File Deleted'
                        })
                    }).catch((error) => {

                    })
                } else {
                    Vue.delete(this.temp.attributes, property);

                }
            },

            add(property, value, type) {
                if (this.Aproperty.trim() !== '' && this.Avalue.trim() !== '') {

                    if (type === 'media') {
                        var property1 = {
                            'value': value,
                            'type': type,
                            'url': this.Aurl
                        };
                    } else {
                        var property1 = {
                            'value': value,
                            'type': type,

                        };
                    }
                    this.temp.attributes[property] = property1;

                    this.Aproperty = '';
                    this.Avalue = null;
                    this.Aurl = null;
                    this.Atype = 'text';
                }
            }


        },
        watch: {
            //watch change in title and generate slug
            temptitle: function () {
                this.temp.title = this.temptitle
                this.temp.slug = this.sanitizeTitle(this.temptitle);
            },

        },    }
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
     .side-bar {
        margin-left: 1.5rem;
        padding-left: 2rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    }
    @media (min-width: 300px) and (max-width: 900px) {
        .side-bar {
            margin-left: 0rem;
        }
    }


</style>
