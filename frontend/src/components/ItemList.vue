<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>Create/Edit/Delete Items</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn flat to="/dashboard/item/create">Create a Item</v-btn>
                </v-toolbar-items>
                <v-toolbar-items>

                        <download-excel
                                :data="getItems"
                                :fields="exportFields"
                                :name="excelFileName"
                        class="height-inherit">
                            <v-btn flat>Download as Excel  &nbsp; <v-icon>fa-file-excel</v-icon></v-btn>
                        </download-excel>


                </v-toolbar-items>

            </v-toolbar>
            <alert-box  />
            <v-data-table
                    :items="getItems"
                    :headers="headers">
                <template slot="items" slot-scope="props">
                    <td>{{ props.index + 1  }}</td>
                    <td>{{ props.item.name }}</td>
                    <td><span v-if="props.item.category">{{ props.item.category.id + ' | ' + props.item.category.name }}</span></td>
                    <td>{{ props.item.price }}</td>
                    <td>{{ props.item.stock }}</td>
                    <td class="justify-center layout px-0">
                        <router-link :to="{name: 'item',params: {id: props.item.id}}">
                        <v-icon small class="mr-2" @click="" >
                            edit
                        </v-icon>
                        </router-link>
                        <v-icon @click="deleteItem(props.item)" small>
                            delete
                        </v-icon>
                    </td>
                </template>

                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        Sorry, No Item Yet.
                    </v-alert>
                </template>
            </v-data-table>

            <v-snackbar
                    v-model="snackbar"
                    right
                    :timeout="6000"
                    color="success"
            >
                {{ snackbarMsg }}
                <v-btn
                        color="black"
                        flat
                        @click="snackbar = false"
                >
                    Close
                </v-btn>
            </v-snackbar>

        </v-card>
    </v-container>
</template>

<script>
    import { mapGetters, mapActions} from 'vuex';
    //import AlertBox from 'src/components/AlertBox';
    import AlertBox from './shared/AlertBox';

    export default {
        name: "ItemList",
        props:{
            msg:String
        },
        components: {
            'alert-box':AlertBox
        },
        data(){
            return {
                alert:false,
                valid:true,
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
                snackbar:false,
                snackbarMsg:'',
                exportFields: {
                    'ID': 'id',
                    'Name': 'name',
                    'Description': 'description',
                    'Price': 'price',
                    'In Stock': 'stock',
                    'Category': {
                        field: 'category',
                        callback: (value) => value!== null?value.id+ '|'+value.name:''
                    }
                }
            }
        },
        created: function(){
            var app = this;
            this.$store.dispatch('fetchItems').then(response => {
                if(this.getAlertMsg){
                    app.snackbar = true;
                    app.snackbarMsg = this.getAlertMsg;
                }
            });




        },
        mounted(){

        },
        computed: {
            ...mapGetters([
                'loading','getItems','getAlertMsg','getAlertType'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            queryStatus(){
                return this.$route.query.status;
            },
            excelFileName(){
                return 'ItemList '+ new Date().toDateString()+'.xlsx'
            }
        },
        watch: {


        },
        methods:{
            editItem(item){

            },
            deleteItem(item){
                this.$root.$confirm('Delete ' +item.name,'Are you sure?',{color:'red'})
                    .then((confirm) => {
                        if(confirm){
                            //if true, call delete end point
                            this.$store.dispatch('deleteItem',item.id)
                                .then(response =>{

                                })
                        }
                        else{

                        }
                    })
            }

        }
    }
</script>

<style scoped>
    .height-inherit{
        height: inherit;
    }
</style>
