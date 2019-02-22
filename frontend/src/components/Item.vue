<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn to="/dashboard/items" flat>Go to ItemList</v-btn>
                </v-toolbar-items>

            </v-toolbar>
            <alert-box />
            <v-card-text>
                <v-form ref="item" v-model="valid">
                    <input type="hidden" v-model="item.id" />


                    <v-text-field prepend-icon="fa-passport" v-model="item.name" label="Name *"></v-text-field>
                    <v-label>Description</v-label>

                    <vue-editor v-model="item.description"></vue-editor>
                    <v-layout justify-space-between column>
                        <v-layout>
                            <v-flex>
                                <v-text-field v-model="item.price" label="Price"
                                              prepend-icon="fa-dollar-sign"></v-text-field>
                            </v-flex>
                            <v-flex>
                                <v-text-field disabled v-model="item.stock" label="Stock"
                                              prepend-icon="fa-database"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-layout>
                   <v-select
                       prepend-icon="fa-layer-group"
                       label="Category *"
                       :items="categories"
                       v-model="item.categoryId"
                       required>

                   </v-select>

                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn    @click="$router.go(-1)">Cancel

                </v-btn>
                <v-btn color="primary" :disabled="!valid || loading" @click="saveItem">{{actionTitle}}
                    <v-icon v-if="loading">fas fa-circle-notch fa-spin</v-icon>
                </v-btn>

            </v-card-actions>


        </v-card>
    </v-container>
</template>

<script>
    import { mapGetters, mapActions} from 'vuex';
    //import AlertBox from 'src/components/AlertBox';
    import AlertBox from './shared/AlertBox';
    import { VueEditor } from 'vue2-editor'

    export default {
        name: "Item",
        props:['msg','id'],
        components: {
            'alert-box':AlertBox,
            VueEditor
        },
        data(){
            return {
                alert:false,
                valid:true,
                item:{
                  id:'',
                  name:'',
                  description:'',
                  category:'',
                  price:'',
                  stock:'',
                  categoryId:''
                },
                items:[],
                headers: [
                    {text: 'SN',value:'sn'},
                    {text: 'Name', sortable: false, value:'name'},
                    {text: 'Category', sortable: false, value:'category'},
                    {text: 'Price', sortable: false, value:'price'},
                    {text: 'Stock', sortable: false, value:'stock'},
                    {text: 'Actions', sortable: false, value:'stock'},
                ],
                selectedItem:{},

            }
        },
        created: function(){
            this.fetchItem();
            this.fetchCategories();

        },
        mounted(){

        },
        computed: {
            ...mapGetters([
                'loading','getItems','getItem','getCategories'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            pageTitle(){
                return this.item.id !== '' || null ? 'Edit '+ this.item.name: 'Create New Item';
            },
            actionTitle(){
                return this.item.id !== '' || null ? 'Save': 'Create'
            },
            categories(){
                return this.getCategories.filter(item => item.parent !== null)
                    .map(item => {
                        return {
                            text: item.name,
                            value: item.id
                        }
                    })
            },
        },
        watch: {


        },
        methods:{
            ...mapActions([
                'fetchCategories'
            ]),
            fetchItem(){
                // if id has value it is edit other wise looking for create value
                if(this.id) {
                    if(this.id === 'create'){
                        // it will be used for create
                    }
                    else {
                        this.$store.dispatch('fetchItem', {id: this.id})
                            .then(response => {
                                this.item.id = response.data.id;
                                this.item.name= response.data.name;
                                this.item.description = response.data.description;
                                this.item.category = response.data.category;
                                this.item.categoryId = response.data.category !== null? response.data.category.id:'';
                                this.item.price = response.data.price;
                                this.item.stock = response.data.stock;

                            })
                    }
                }
            },
            saveItem(item){
                this.$store.dispatch('saveItem',this.item)
                    .then(response => {
                        this.$router.push({path: '/dashboard/items'/*, query: { status: response.data.message}*/});

                })
                    .catch(error => {
                        console.log(error);
                    });
            }

        }
    }
</script>

<style scoped>

</style>
