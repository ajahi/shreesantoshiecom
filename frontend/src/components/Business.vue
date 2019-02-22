<template>
    <v-container>
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>{{ taskTitle }}</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <alert-box/>
            <v-card-text>
                <v-form ref="business" v-model="valid">
                    <input type="hidden" v-model="getBusiness.id">

                    <v-text-field v-model="getBusiness.name" label="Title *"></v-text-field>
                    <!--<v-textarea v-model="getBusiness.description" label="Description *"></v-textarea>-->
                    <vue-editor v-model="getBusiness.description"></vue-editor>

                    <v-layout justify-space-between column>
                        <v-layout row>
                            <v-flex>
                                <v-text-field v-model="getBusiness.phone" label="Phone"
                                              prepend-icon="phone"></v-text-field>
                            </v-flex>
                            <v-flex>
                                <v-text-field v-model="getBusiness.website" label="Website"
                                              prepend-icon="web"></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-select
                                prepend-icon="category"
                                label="Category *"
                                :items="categories"
                                v-model="getBusiness.categoryId"
                                required>
                        </v-select>
                        <v-select
                                prepend-icon="location_on"
                                label="Location *"
                                :items="locations"
                                v-model="getBusiness.locationId"
                                required>
                        </v-select>
                        <v-layout row>
                            <v-layout  row>
                                <label class="text-md-center">Rating </label>
                                <v-rating v-model="getBusiness.rating" label="Rating"
                                ></v-rating>
                            </v-layout>
                            <v-spacer></v-spacer>
                            <v-flex>
                                <v-text-field v-model="getBusiness.hours" label="Opening Hours"
                                              prepend-icon="access_time"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-layout>


                </v-form>




            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" :disabled="!valid || loading" @click="saveBusiness">{{actionTitle}}
                    <v-icon v-if="loading">fas fa-circle-notch fa-spin</v-icon>
                </v-btn>

            </v-card-actions>

        </v-card>

        <v-spacer></v-spacer>

        <v-card>
            <v-toolbar color="white">
                <v-toolbar-title>Edit Business Gallery(Images)</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <alert-box/>
            <v-card-text>

                <!--
                customer image upload
                <image-input v-model="avatar" @input="onFileChanged">
                     <div slot="activator">
                         <v-avatar size="150px" v-ripple v-if="!avatar" class="grey lighten-3 mb-3">
                             <span>Click to add avatar</span>
                         </v-avatar>
                         <v-avatar size="150px" v-ripple v-else class="mb-3">
                             <img :src="avatar.imageURL" alt="avatar">
                         </v-avatar>
                     </div>
                 </image-input>
                 <v-slide-x-transition>
                     <div v-if="avatar && saved == false">
                         <v-btn class="primary" @click="uploadImage" :loading="saving">Save Avatar</v-btn>
                     </div>
                 </v-slide-x-transition>
                -->



                <vue-dropzone id="drop1" ref="dropzone"  :options="dropOptions" @vdropzone-processing="dropzoneprocessImage"
                              @vdropzone-mounted="dropzoneMounted" @vdropzone-removed-file="fileRemoved" @vdropzone-success="uploadSuccess"
                              :destroyDropzone="false"></vue-dropzone>






            </v-card-text>
        </v-card>


    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex';
    import AlertBox from './shared/AlertBox';
    import { VueEditor } from 'vue2-editor'
    import ImageInput from './shared/ImageInput';
    import FileContainer from './shared/FileContainer';
    import vueDropzone from "vue2-dropzone";


    export default {
        name: 'Business',
        components: {
            'alert-box': AlertBox,
            VueEditor,
            ImageInput: ImageInput,
            FileContainer,
            vueDropzone

        },
        data() {
            return {
                alert: false,
                valid: true,


                dropOptions: {
                    url: "https://httpbin.org/post",
                    addRemoveLinks: true,
                    headers: { 'Authorization' : 'Bearer ' + this.$store.getters.getToken }
                }



            }
        },
        created: function () {
            this.$store.commit('setLayout', 'app-layout');
            this.$store.dispatch('fetchBusiness');
            this.$store.dispatch('fetchLocations');
            this.$store.dispatch('fetchBusinessCategories');
        },
        mounted() {


        },
        computed: {
            ...mapGetters([
                'loading', 'getBusiness',"getLocations","getBusinessCategories","fetchLocations","fetchBusinessCategories","getServerUrl"
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            gallery(){
                return this.getBusiness.gallerySet;
            },
            locations(){
                return this.getLocations.map(item => {
                    return {
                        text: item.city + " " + item.state + " " + item.zipcode,
                        value: item.id
                    }
                })
            },
            categories(){
                return this.getBusinessCategories.filter(item => item.parent !== null)
                    .map(item => {
                    return {
                        text: item.name,
                        value: item.id
                    }
                })
            },
            actionTitle(){
                return this.getBusiness.id === null || "" ? "Create": 'Save';

            },
            taskTitle(){
                return this.getBusiness.id === null || "" ? 'Create Business': 'Edit Business';
            },


        },
        watch: {
            /*gallery:function(value,old){
                var app = this;
                value.forEach(function(value){
                    // console.log('http://localhost:8080/downloadFile/'+value.imageUrl);

                    var file ={ size: value.size || 5000, name: value.imageUrl, type: value.type || 'image/png', id: value.id};
                    //    console.log('http://localhost:8080/downloadFile/vuetify.png')
                    app.$refs.dropzone.manuallyAddFile(file,app.getServerUrl+'/downloadFile/'+ value.imageUrl);
                });

            }*/
        },
        methods: {
            saveBusiness(){
                if(this.$refs.business.validate()){
                    this.$store.dispatch('saveBusiness');
                }
            },
            dropzoneprocessImage(file) {
                this.$refs.dropzone.setOption('url',this.getServerUrl +'/business/'+this.getBusiness.id +'/image');
            },
            addedFile(file){
                //console.log(file);
            },
            dropzoneMounted(){
                var app = this;
                this.gallery.forEach(function(value){
                   // console.log('http://localhost:8080/downloadFile/'+value.imageUrl);

                    var file ={ size: value.size || 5000, name: value.imageUrl, type: value.type || 'image/png', id: value.id};
                //    console.log('http://localhost:8080/downloadFile/vuetify.png')
                    app.$refs.dropzone.manuallyAddFile(file,app.getServerUrl+'/downloadFile/'+ value.imageUrl);
                });

            },
            fileRemoved(file,error,xhr){
                //remove file from server
                this.$store.dispatch('deleteBusinessImage',{id: file.id});

            },
            uploadSuccess(file,response){
                file.id= response.id;
            }
        }
    }

</script>
