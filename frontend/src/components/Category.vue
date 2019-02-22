<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>Edit Category</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-dialog v-model="dialog" max-width="500px" >
                    <v-btn slot="activator" color="primary " dark class="mb-2" >Create New Root Category</v-btn>
                    <v-btn slot="activator" color="primary " dark class="mb-2" @click="createFlag = true" >Create New Child Category</v-btn>

                    <v-form ref="category" v-model="valid">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ dialogTitle }}</span>
                        </v-card-title>
                        <alert-box />

                        <v-card-text>

                            <v-container grid-list-md>
                                <v-layout wrap>
                                    <v-flex>
                                        <v-text-field v-model="selectedItem.name" label="title"></v-text-field>
                                    </v-flex>
                                    <v-flex v-if="selectedItem.parent || createFlag ">
                                        <v-select :items="parentCategories"  v-model="selectedItem.parent" label="Parent"></v-select>
                                    </v-flex>
                                </v-layout>
                            </v-container>

                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click.native="saveCategory">Save</v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-form>

                </v-dialog>

            </v-toolbar>



            <v-data-table
            :items="getCategories"
            :headers="headers">
                <template slot="items" slot-scope="props">
                    <td>{{ props.index + 1  }}</td>
                    <td>{{ props.item.name }}</td>
                    <td><span v-if="props.item.parent">{{ props.item.parent.id + ' | ' + props.item.parent.name }}</span></td>
                    <td class="justify-center layout px-0">
                        <v-icon small class="mr-2" @click="editItem(props.item)" >
                            edit
                        </v-icon>
                        <v-icon small>
                            delete
                        </v-icon>
                    </td>
                </template>

                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        Sorry, No Category Yet.
                    </v-alert>
                </template>
            </v-data-table>

        </v-card>
    </v-container>
</template>


<script>
    import { mapGetters, mapActions} from 'vuex';
    //import AlertBox from 'src/components/AlertBox';
    import AlertBox from './shared/AlertBox';

    export default {
        name: 'Category',
        props: {
            msg: String
        },
        components: {
           'alert-box': AlertBox
        },
        data() {
            return {
                alert: false,
                valid:true,
                items:[],
                dialog: false,
                headers: [
                    {text: 'SN',value:'sn'},
                    {text: 'Title', sortable: false, value:'name'},
                    {text: 'Parent', sortable:false,value:'parent'}
                ],
                selectedItem: {
                    id: '',
                    name:'',
                    parent: ''
                },
                createFlag: false,
            }
        },
        created: function(){
            //this.$store.commit('setLayout','app-layout')
            this.$store.dispatch('fetchCategories');
        },
        mounted(){
        },
        computed: {
            ...mapGetters([
                'loading','getCategories'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            parentCategories(){
                return this.getCategories.filter(item => {
                    return item.parent === null;
                }).map(item => {
                    return {
                        text: item.name,
                        value: item.id
                    };
                });

            },
            dialogTitle(){
                return this.selectedItem.id != null || '' ? 'Edit Category' : 'Create Category'
            },


        },
        watch: {
            /*alertMsg(value) {
                if (value) {
                    this.alert = true;
                }
            },*/
           /* alert(value) {
                if (!value) {
                    this.$store.commit('setAlertMsg', null)
                }
            }*/
           dialog(value){
               if(!value){
                   // empty selected item
                   this.selectedItem = {
                       id: '',
                       name:'',
                       parent: ''};
                   this.createFlag = false;
               }
           }

        },
        methods: {
            saveCategory(){
                if(this.$refs.category.validate()){
                    this.$store.dispatch('saveCategory',this.selectedItem)
                        .then(response =>{
                        if(response.data.created_id){
                            this.selectedItem.id = response.data.created_id;
                        }
                    })
                }
            },
            editItem(item){
                this.setSelectedItem(item);
                this.dialog= true;
            },
            setSelectedItem(item){
                this.selectedItem.id = item.id;
                this.selectedItem.name= item.name;
                if(item.parent) {
                    this.selectedItem.parent = item.parent.id;
                }
            },


        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    h3 {
        margin: 40px 0 0;
    }
    ul {
        list-style-type: none;
        padding: 0;
    }
    li {
        display: inline-block;
        margin: 0 10px;
    }
    a {
        color: #42b983;
    }
</style>
