<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white" v-if="!externalUse">
                <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn to="/dashboard/suppliers" flat>Go to SupplierList</v-btn>
                </v-toolbar-items>

            </v-toolbar>
            <alert-box />
            <v-card-text>
                <v-form ref="supplier" v-model="valid">
                    <input type="hidden" v-model="supplier.id" />


                    <v-text-field prepend-icon="fa-passport" v-model="supplier.name" label="Name *"></v-text-field>
                    <v-label>Description</v-label>

                    <vue-editor v-model="supplier.description"></vue-editor>
                    <v-layout justify-space-between column>
                        <v-layout>
                            <v-flex>
                                <v-text-field v-model="supplier.address" label="Address"
                                              prepend-icon="fa-address-card"></v-text-field>
                            </v-flex>
                            <v-flex>
                                <v-text-field  v-model="supplier.contactNo" label="Contact No"
                                              prepend-icon="fa-phone"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-layout>

                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn    @click="$router.go(-1)">Cancel

                </v-btn>
                <v-btn color="primary" :disabled="!valid || loading" @click="saveSupplier">{{actionTitle}}
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
        name: "Supplier",
        props:['msg','id','external-use'],
        components: {
            'alert-box':AlertBox,
            VueEditor
        },
        data(){
            return {
                alert:false,
                valid:true,
                suppliers:[],
                supplier:{
                    id:'',
                    name:'',
                    description:'',
                    contactNo:'',
                    address:''
                },
                selectedSupplier:{},

            }
        },
        created: function(){
            this.fetchSupplier();
            this.fetchCategories();

        },
        mounted(){

        },
        computed: {
            ...mapGetters([
                'loading','getSuppliers','getSupplier','getCategories'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            pageTitle(){
                return this.supplier.id !== '' || null ? 'Edit '+ this.supplier.name: 'Create New Supplier';
            },
            actionTitle(){
                return this.supplier.id !== '' || null ? 'Save': 'Create'
            },
            categories(){
                return this.getCategories.filter(supplier => supplier.parent !== null)
                    .map(supplier => {
                        return {
                            text: supplier.name,
                            value: supplier.id
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
            fetchSupplier(){
                // if id has value it is edit other wise looking for create value
                if(this.id) {
                    if(this.id === 'create'){
                        // it will be used for create
                    }
                    else {
                        this.$store.dispatch('fetchSupplier', {id: this.id})
                            .then(response => {
                                this.supplier.id = response.data.id;
                                this.supplier.name = response.data.name;
                                this.supplier.description = response.data.description;
                                this.supplier.address = response.data.address;
                                this.supplier.contactNo = response.data.contactNo;
                            })
                    }
                }
            },
            saveSupplier(supplier){
                this.$store.dispatch('saveSupplier',this.supplier)
                    .then(response => {
                        // if this.externalUse in true return the supplier as $emit
                        if(!this.externalUse){
                            this.$router.push({path: '/dashboard/suppliers'/*, query: { status: response.data.message}*/});
                        }
                        else{
                            this.supplier.id = response.data.created_id;
                            this.$emit('created-supplier',this.supplier);
                        }

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
