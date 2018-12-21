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
                            <p style="padding: 10px" v-for="(value, propertyName) in temp.attributes">
                                <el-button>{{ propertyName }} </el-button>: <el-button>{{ value }} </el-button><el-button type="danger" @click="remove(propertyName)">X</el-button>
                            </p>

                        </div>
                        <el-row :gutter="20">
                            <el-col :xl="5" :lg="5" :md="5">
                                <el-input v-model="Aproperty" placeholder="Property" type="text"/>
                            </el-col>
                            <el-col :xl="5" :lg="5" :md="5">
                                <el-input v-model="Avalue" placeholder="Value" type="text"/>
                            </el-col>
                            <el-col :xl="5" :lg="5" :md="5">
                                <el-button @click="add(Aproperty,Avalue)">Add</el-button>
                            </el-col>
                        </el-row>
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
    import Vue from 'vue'

    import waves from '../../directive/waves/index.js'

    export default {
        name: 'Role-Detail',
        components: {},


        directives: {
            waves
        },
        filters: {},
        data() {

            return {
                Aproperty: '',
                Avalue: '',
                //required element
                permissions: [],
                //tracking variable
                tempName: '',

                //form element
                temp: {},

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
                this.$axios.get('/site/').then(response => {
                    this.temp = response.data
                    console.log(this.temp);
                })
            },
            upload() {
                this.$refs['dataForm'].validate((valid) => {

                    if (valid) {
                        this.apiCall = true;
                        this.$axios.post('/site/', this.temp).then(response => {
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
                Vue.delete(this.temp.attributes, property);
            },

            add(property, value) {
                if (this.Aproperty.trim() !== '' && this.Avalue.trim() !== '') {
                    this.temp.attributes[property] = value;
                    this.Aproperty = '';
                    this.Avalue = '';
                }
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
