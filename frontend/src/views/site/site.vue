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
                    <el-form-item label="Website Title" style="margin-bottom: 40px;" prop="title">
                        <el-input v-model="temp.title" type="text"/>
                        <span style="color: red" v-if="errors.title">
                            <li v-for="item in errors.title">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Logo" prop="logo">
                        <br>
                        <img :src="temp.logo" style="max-width: 100%; height: auto;">
                        <br>
                        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                    </el-form-item>

                    <el-form-item label="Slogan" prop="slogan">
                        <el-input v-model="temp.slogan" type="name"/>
                        <span style="color: red" v-if="errors.slogan">
                            <li v-for="item in errors.slogan">{{item}}</li>
                        </span>
                    </el-form-item>


                    <el-form-item label="Description" prop="description">
                        <el-input v-model="temp.description" type="text"/>
                        <span style="color: red" v-if="errors.description">
                            <li v-for="item in errors.description">{{item}}</li>
                        </span>
                    </el-form-item>


                    <el-form-item label="Email" prop="email">
                        <el-input v-model="temp.email" type="email"/>
                        <span style="color: red" v-if="errors.email">
                            <li v-for="item in errors.email">{{item}}</li>
                        </span>
                    </el-form-item>

                    <el-form-item label="Location" prop="location">
                        <el-input v-model="temp.location" type="text"/>
                        <span style="color: red" v-if="errors.location">
                            <li v-for="item in errors.location">{{item}}</li>
                        </span>

                    </el-form-item>

                    <el-form-item label="telephone" prop="telephone">
                        <el-input v-model="temp.telephone" type="text"/>
                        <span style="color: red" v-if="errors.telephone">
                            <li v-for="item in errors.telephone">{{item}}</li>
                        </span>

                    </el-form-item>


                    <el-form-item label="Working Days" prop="working_days">
                        <el-input v-model="temp.working_days" type="text"/>
                        <span style="color: red" v-if="errors.working_days">
                            <li v-for="item in errors.working_days">{{item}}</li>
                        </span>

                    </el-form-item>


                    <el-form-item label="Facebook" prop="facebook">
                        <el-input v-model="temp.facebook" type="text"/>
                        <span style="color: red" v-if="errors.facebook">
                            <li v-for="item in errors.facebook">{{item}}</li>
                        </span>

                    </el-form-item>

                    <el-form-item label="Google" prop="google">
                        <el-input v-model="temp.google" type="text"/>
                        <span style="color: red" v-if="errors.google">
                            <li v-for="item in errors.google">{{item}}</li>
                        </span>

                    </el-form-item>

                    <el-form-item label="Twitter" prop="twitter">
                        <el-input v-model="temp.twitter" type="text"/>
                        <span style="color: red" v-if="errors.twitter">
                            <li v-for="item in errors.twitter">{{item}}</li>
                        </span>

                    </el-form-item>


                    <el-form-item label="Instagram" prop="instagram">
                        <el-input v-model="temp.instagram" type="text"/>
                        <span style="color: red" v-if="errors.instagram">
                            <li v-for="item in errors.instagram">{{item}}</li>
                        </span>

                    </el-form-item>


                    <el-form-item label="Linkedin" prop="linkedin">
                        <el-input v-model="temp.linkedin" type="text"/>
                        <span style="color: red" v-if="errors.linkedin">
                            <li v-for="item in errors.linkedin">{{item}}</li>
                        </span>

                    </el-form-item>

                    <el-form-item label="skype" prop="skype">
                        <el-input v-model="temp.skype" type="text"/>
                        <span style="color: red" v-if="errors.skype">
                            <li v-for="item in errors.skype">{{item}}</li>
                        </span>

                    </el-form-item>

                    <el-form-item label="Additional property">
                        <br>
                        <div>
                            <el-row  :gutter="20">


                                <p style="padding: 10px" v-for="(value,propertyName) in temp.attributes">
                                    <el-button v-if="userrole.name === 'super_admin'" type="danger" @click="remove(propertyName)">X</el-button>

                                    <el-input v-if="userrole.name === 'super_admin'" style="width: 100px" v-model="propertyName"></el-input>
                                    <label v-else>{{propertyName}}</label>

                                    :
                                    <el-select v-if="userrole.name === 'super_admin'" style="width: 100px" v-model="temp.attributes[propertyName]['type']"
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
                                    <Tinymce :height=400 v-if="temp.attributes[propertyName]['type'] === 'editor'"
                                             v-model="temp.attributes[propertyName]['value']"/>
                                    <el-input  style="width: 40%"
                                               v-if="temp.attributes[propertyName]['type'] === 'text'"  v-model="temp.attributes[propertyName]['value']"></el-input>
                                    <a style="width: 40%" class="btn"  v-if="temp.attributes[propertyName]['type'] === 'media'"
                                       :href="temp.attributes[propertyName]['url'] | CompleteUrl(base_url) "  >{{propertyName}}</a>

                                </p>
                            </el-row>
                        </div>
                        <el-row v-if="userrole.name === 'super_admin'" :gutter="20">
                            <el-col :xl="5" :lg="5" :md="5">
                                <el-input v-model="Aproperty" placeholder="Property" type="text"/>
                            </el-col>
                            <el-col :xl="5" :lg="5" :md="5">
                                <el-input v-if="Atype === 'text'" v-model="Avalue" placeholder="Value" type="text"/>
                                <Tinymce :height=400 v-if="Atype === 'editor'" v-model="Avalue" />
                                <input type="file" id="uploadFile" v-if="Atype === 'media'" ref="file1" v-on:change="handleMediaUpload()"/>

                            </el-col>
                            <el-col  :xl="5" :lg="5" :md="5">
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
            </el-form>



            <div slot="footer" class="dialog-footer">
                <el-button type="primary" :loading="apiCall" @click="upload" style="width: 120px;">Save</el-button>
            </div>
        </div>

    </div>
</template>

<script>
    import Vue from 'vue'
    import Tinymce from '../../components/Tinymce'

    import waves from '../../directive/waves/index.js'
    import { mapGetters } from 'vuex'

    export default {
        name: 'Role-Detail',
        components: {Tinymce},


        directives: {
            waves
        },
        data() {

            return {
                Aproperty: '',
                Avalue: null,
                Atype: 'text',
                Aurl:null,
                //required element
                permissions: [],
                //tracking variable
                tempName: '',

                //form element
                temp: {},

                file: null,
                file1: null,


                //errors
                errors: [],

                //form validation rule


                //state variable
                apiCall: false

            }
        },
        created() {

            this.fetchData();

        },
        methods: {
            fetchData() {
                this.$axios.get('/site').then(response => {
                    this.temp = response.data
                    // console.log(this.temp);
                })
            },
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            handleMediaUpload() {
                this.file1 = this.$refs.file1.files[0];
                if (this.file1) {
                    var formData = new FormData();

                    formData.append('file', this.file1);
                    this.$axios.post('/site/upload', formData , {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }).then(response => {

                        this.Avalue = response.data.file;
                        this.Aurl = response.data.url;

                        this.$message({
                            type: 'success',
                            message: 'File updated'
                        })
                    }).catch((error) => {

                    })
                }


            },
            deleteMedia(name){
                this.$axios.post('/site/media/delete',{
                    file : name
                }).then(response => {

                    this.$message({
                        type: 'success',
                        message: 'File Deleted'
                    })
                }).catch((error) => {

                })
            },
            upload() {
                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.apiCall = true;
                        var formData = new FormData();
                        formData.append('title', this.temp.title);
                        formData.append('slogan', this.temp.slogan);
                        formData.append('description', this.temp.description);
                        formData.append('logo', this.temp.logo);
                        formData.append('website', this.temp.website);
                        formData.append('location', this.temp.location);
                        formData.append('email', this.temp.email);

                        formData.append('telephone', this.temp.telephone);
                        formData.append('working_days', this.temp.working_days);
                        formData.append('facebook', this.temp.facebook);
                        formData.append('google', this.temp.google);
                        formData.append('twitter', this.temp.twitter);
                        formData.append('instagram', this.temp.instagram);
                        formData.append('linkedin', this.temp.linkedin);
                        formData.append('skype', this.temp.skype);
                        formData.append('attributes', JSON.stringify(this.temp.attributes));
                        if (this.file) {

                            formData.append('file', this.file);
                        }

                        this.$axios.post('/site', formData).then(response => {
                            this.temp = response.data
                            this.apiCall = false;

                            this.$message({
                                type: 'success',
                                message: 'Site updated'
                            })
                        }).catch((error) => {
                            this.apiCall = false;
                            this.errors = error.response.data;

                        })
                    }
                })
            },
            remove(property) {
                if(this.temp.attributes[property].type === 'media'){
                    this.$axios.post('/site/media/delete',{
                        file : this.temp.attributes[property].type.value
                    }).then(response => {
                        Vue.delete(this.temp.attributes, property);

                        this.$message({
                            type: 'success',
                            message: 'File Deleted'
                        })
                    }).catch((error) => {

                    })
                }
                else{
                    Vue.delete(this.temp.attributes, property);

                }
            },

            add(property, value, type) {
                if (this.Aproperty.trim() !== '' && this.Avalue.trim() !== '') {

                    if(type === 'media'){
                        var property1 = {
                            'value': value,
                            'type': type,
                            'url' : this.Aurl
                        };
                    }else{
                        var property1 = {
                            'value': value,
                            'type': type,

                        };
                    }
                    this.temp.attributes[property] = property1;

                    this.Aproperty = '';
                    this.Avalue = null;
                    this.Aurl= null;
                    this.Atype  = 'text';
                }
            }
        },
        watch: {},
        computed :{
            ...mapGetters([
                'userrole'
            ]),
            base_url: function () {
                // `this` points to the vm instance
                return process.env.BASE_URL
            }

        },

        filters:{
            /**
             * @return {string}
             */
            CompleteUrl:  function (value , url) {
                return url+value;
            }
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
