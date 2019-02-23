<template>
    <v-container>
        <v-layout row wrap align-center >
            <v-card class="elevation-12">
                <v-card-title>
                    <div>
                        <h3 class="headline">{{title}}</h3>

                    </div>
                </v-card-title>
                <!--<v-flex>
                    <v-alert :type="alertType" dismissible v-model="alert">
                        {{ alertMsg }}
                    </v-alert>
                </v-flex>-->
                <alert-box/>
                <v-card-text>

                    <v-form ref="category" v-model="valid">
                        <v-container grid-list-md text-md-center>
                            <v-layout row wrap>
                                <input type="hidden" v-model="category.id"/>
                                <v-flex md12 sm12>
                                    <v-text-field
                                            prepend-icon="person"
                                            name="category"
                                            label="Category *"
                                            type="text"
                                            v-model="category.title"
                                            :rules="requiredRules"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex md12 sm12>
                                    <v-text-field
                                            prepend-icon="person"
                                            name="url"
                                            label="Category Url *"
                                            type="url"
                                            v-model="category.url"
                                            :rules="requiredRules"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex md6>

                                        <img height="200px" width="150px" :src="category.image | downloadUrl " alt="avatar" v-if="category.image">
                                    <input type="file"
                                           ref="file"
                                           name="file"
                                           required
                                           @change="onFileChange(
          $event.target.name, $event.target.files)"
                                          >
                                    <br />
                                </v-flex>


                                <v-flex md6>
                                    <v-menu
                                            v-model="monthMenu"
                                            :close-on-content-click="false"
                                            :nudge-right="40"
                                            lazy
                                            transition="scale-transition"
                                            offset-y
                                            full-width
                                            min-width="290px"
                                    >
                                        <v-text-field
                                                slot="activator"
                                                v-model="category.month"
                                                label="Establishment Date"
                                                readonly
                                        ></v-text-field>
                                        <v-date-picker v-model="category.month" @input="monthMenu = false"></v-date-picker>
                                    </v-menu>
                                </v-flex>

                            </v-layout>
                        </v-container>

                    </v-form>

                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn color="primary" :disabled="!valid || loading" @click="saveCategory">Save
                        <v-icon v-if="loading">fas fa-circle-notch fa-spin</v-icon>
                    </v-btn>
                    <v-btn @click="$router.go(-1)">Cancel

                    </v-btn>

                </v-card-actions>

            </v-card>
        </v-layout>
    </v-container>

</template>

<script>
    import { mapGetters} from 'vuex';
    import AlertBox from '../../shared/AlertBox';

    export default {
        name: "member",
        props: ['msg','id'],
        components: {
            'alert-box': AlertBox,
        },
        data() {
            return {
                alert: false,
                valid: true,
                requiredRules: [
                    v => !!v || 'Required field'
                ],
                category:{
                    title:'',
                    month:'',
                    url:''
                },
                monthMenu: false,
                formData:null
            }
        },
        created: function(){
            this.fetchCategory()

        },
        mounted(){

        },
        methods:{
            fetchCategory(){
                if(this.id){
                  if(this.id ==='create'){
                      this.$store.dispatch('clearCategory');

                  }
                  else {
                      this.$store.dispatch('fetchCategory',this.id)
                          .then(response => {
                              this.category = response.data;
                          })
                  }
              }
            },
            saveCategory(){
                if(this.$refs.category.validate()){
                    this.$store.dispatch('saveCategory',this.category).then(response => {
                        if(response.data.created_id){
                            this.category.id = response.data.created_id;
                        }
                        if(this.formData){
                            this.axios.post('/category/'+this.category.id+'/image',this.formData)
                                .then(res => {
                                    this.$store.dispatch('showSuccessSnackbar',response.data.message);
                                    this.$router.push({name:'categorys'});
                                });

                        }else{
                            this.$store.dispatch('showSuccessSnackbar',response.data.message);
                            this.$router.push({name:'categorys'});
                        }


                    })
                        .catch(error => {
                            console.log("error"+error);
                            this.$store.dispatch('showErrorSnackbar',error);


                        })
                }
            },
            onFileChange(fieldName, file) {
                const { maxSize } = this
                let categoryFile = file[0]
                if (file.length>0) {
                    // let size = categoryFile.size / maxSize / maxSize
                        // Append file into FormData and turn file into image URL
                        this.formData = new FormData()
                        let imageURL = URL.createObjectURL(categoryFile)
                        this.formData.append(fieldName, categoryFile)
                        // Emit the FormData and image URL to the parent component
                }
            }
        },
        computed: {
            ...mapGetters([
                'loading','getCategory'
            ]),
            title(){
                if(this.category.id){
                    return "Edit "+ this.category.title
                }
                else
                    return "Create Category"

            },
            loading(){
                return this.$store.getters.loading;
            }
        }
    }
</script>

<style scoped>

</style>
