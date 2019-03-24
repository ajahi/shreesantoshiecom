<template>
    <v-container>
            <v-card class="elevation-12">
                <v-card-title>
                    <div>
                        <h3 class="headline">{{title}}</h3>

                    </div>
                </v-card-title>
                <v-card-text>

                    <v-form ref="post" v-model="valid">
                        <v-container grid-list-md text-md-center>
                            <v-layout row wrap align-center>
                                <input type="hidden" v-model="post.id"/>
                                <v-flex md12 sm12>
                                    <v-text-field
                                            name="post"
                                            label="Post *"
                                            type="text"
                                            v-model="post.title"
                                            :rules="requiredRules"
                                            data-vv-name="title"
                                            :error-messages="errors.first('title')"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex md12 sm12>
                                   <!-- <v-textarea
                                            name="description"
                                            label="Description *"
                                            type="text"
                                            v-model="post.description"
                                            :rules="requiredRules"
                                            data-vv-name="description"
                                            :error-messages="errors.first('description')"
                                    ></v-textarea>-->
                                    <v-textarea
                                        v-model="post.description">
                                    </v-textarea>

                                   <!-- <vue-editor
                                            :customModules="customModulesForEditor"
                                            :editorOptions="editorSettings"
                                            v-model="post.description"></vue-editor>-->

                                </v-flex>
                                <v-flex md12 sm12 >
                                    <v-text-field
                                            prepend-icon="person"
                                            name="status"
                                            label="Status *"
                                            v-model="post.status"
                                            :rules="requiredRules"
                                    ></v-text-field>
                                </v-flex>

                            </v-layout>
                        </v-container>

                    </v-form>

                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="primary" :disabled="!valid || loading" @click="savePost">Save
                        <v-icon v-if="loading">fas fa-circle-notch fa-spin</v-icon>
                    </v-btn>
                    <v-btn @click="$router.go(-1)">Cancel

                    </v-btn>

                </v-card-actions>

            </v-card>
    </v-container>

</template>

<script>
    import { mapGetters} from 'vuex';
    import AlertBox from '../../shared/AlertBox';

    import { VueEditor,Quill } from 'vue2-editor'
    import { ImageDrop } from "quill-image-drop-module";
    import ImageResize from "quill-image-resize-module";

    export default {
        name: "post",
        props: ['msg','id'],
        components: {
            'alert-box': AlertBox,
            'vue-editor': VueEditor
        },
        inject: ['$validator'],
        data() {
            return {
                customModulesForEditor: [
                    { alias: "imageDrop", module: ImageDrop },
                    { alias: "imageResize", module: ImageResize }
                ],
                editorSettings: {
                    modules: {
                        imageDrop: true,
                        imageResize: {}
                    }
                },
                alert: false,
                valid: true,
                requiredRules: [
                    v => !!v || 'Required field'
                ],
                post:{},
                monthMenu: false,
                formData:null
            }
        },
        created: function(){
            this.fetchPost()

        },
        mounted(){

        },
        methods:{
            fetchPost(){
                if(this.id){
                  if(this.id ==='create'){
                      this.$store.dispatch('clearPost');

                  }
                  else {
                      this.$store.dispatch('fetchPost',this.id)
                          .then(response => {
                              this.post = response.data.data;
                          })
                  }
              }
            },
            savePost(){
                if(this.$refs.post.validate()){
                    this.$store.dispatch('savePost',this.post).then(response => {
                        if(response.status === 201){
                            this.$store.dispatch('showSuccessSnackbar','Post was created successfully');
                        }else{
                            this.$store.dispatch('showSuccessSnackbar','Post was edited successfully');
                        }
                        this.$router.push({name:'categories'});

                    })
                        .catch(error => {
                            this.$store.dispatch('showErrorSnackbar',error);


                        })
                }
            },
            onFileChange(fieldName, file) {
                const { maxSize } = this
                let postFile = file[0]
                if (file.length>0) {
                    // let size = postFile.size / maxSize / maxSize
                        // Append file into FormData and turn file into image URL
                        this.formData = new FormData()
                        let imageURL = URL.createObjectURL(postFile)
                        this.formData.append(fieldName, postFile)
                        // Emit the FormData and image URL to the parent component
                }
            }
        },
        computed: {
            ...mapGetters([
                'loading','getPost'
            ]),
            title(){
                if(this.post.id){
                    return "Edit "+ this.post.title
                }
                else
                    return "Create Post"

            },
            loading(){
                return this.$store.getters.loading;
            }
        }
    }
</script>

<style scoped>

</style>
