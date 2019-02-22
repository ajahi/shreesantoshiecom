<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn to="/dashboard/sales" flat>Go to SaleList</v-btn>
                </v-toolbar-items>

            </v-toolbar>
            <alert-box />
            <v-card-text>
                <v-form ref="item" v-model="valid">
                    <input type="hidden" v-model="sale.id" />


                    <v-text-field prepend-icon="fa-passport" v-model="sale.narration" label="Narration *"></v-text-field>
                    <!--<v-layout justify-space-between column>
                        <v-layout>
                            <v-flex>
                                <v-text-field  v-model="sale.voucherNo" label="Voucher No"
                                              prepend-icon="fa-file-invoice "></v-text-field>
                            </v-flex>
                            <v-flex>
                                &lt;!&ndash;<v-text-field  v-model="sale.billNature" label="Bill Nature"
                                              prepend-icon="layers"></v-text-field>&ndash;&gt;
                                <v-select
                                :items="billType"
                                v-model="sale.billNature"
                                label="Bill Nature"
                                prepend-icon="layers">

                                </v-select>
                            </v-flex>
                        </v-layout>
                    </v-layout>-->

                    <!-- edit table for crud of item-->
                    <v-data-table
                        :headers="headers"
                        :items="sale.saleDetails"
                        item-key="itemId"
                        >
                        <template slot="items" slot-scope="props">

                            <td >{{ props.index + 1}}</td>
                            <td>{{ props.item.name }}</td>
                            <td>{{ props.item.categoryName}}</td>
                            <td><v-text-field type="number" required :ref="'item'+props.item.itemId" v-model="props.item.quantity" ></v-text-field></td>
                            <td>{{ props.item.price}}</td>
                            <td>{{ props.item.quantity * props.item.price || props.item.price }}</td>
                            <td>
                                <v-icon @click="removeItem(props.item)">delete</v-icon>
                            </td>
                        </template>
                        <template slot="footer">
                            <tr>
                            <td colspan="100%">
                                <template>

                                    <v-layout  column fill-height>
                                        <v-menu  :close-on-content-click="false" v-model="addItemMenu">
                                            <v-btn flat block color="primary" slot="activator"><v-icon>add</v-icon> Add an Item</v-btn>
                                            <v-card >
                                                <v-card-text>
                                                    <v-autocomplete
                                                        v-model="model"
                                                        :items="items"
                                                        :loading="isLoading"
                                                        :search-input.sync="search"
                                                        hide-no-data
                                                        hide-selected
                                                        item-text="name"
                                                        item-value="id"
                                                        label="Search Items"
                                                        placeholder="Start typing to Search"
                                                        prepend-icon="fa-search"
                                                        return-object
                                                        multiple
                                                        ref="autoComplete">

                                                        <template slot="selection" slot-scope="data"></template>

                                                    </v-autocomplete>
                                                        <!--not needed in sale -->
                                                        <!--<v-expansion-panel  >
                                                                <v-expansion-panel-content
                                                                        v-for="(item,i) in 1"
                                                                        :key="i"
                                                                >
                                                                    <div slot="header" ><v-btn flat block color="primary">Or Create an Item & Add</v-btn></div>
                                                                    <v-card >
                                                                        <v-card-text>
                                                                            <v-form ref="item" v-model="itemValid">


                                                                                <v-text-field prepend-icon="fa-passport" v-model="getItem.name" label="Name *" required></v-text-field>
                                                                                &lt;!&ndash;<v-label>Description</v-label>

                                                                                <vue-editor v-model="getItem.description"></vue-editor>&ndash;&gt;
                                                                                <v-layout justify-space-between column>
                                                                                    <v-layout>
                                                                                        <v-flex>
                                                                                            <v-text-field v-model="getItem.price" label="Price"
                                                                                                          prepend-icon="fa-dollar-sign"></v-text-field>
                                                                                        </v-flex>
                                                                                    </v-layout>
                                                                                </v-layout>
                                                                                <v-select
                                                                                        prepend-icon="fa-layer-group"
                                                                                        label="Category *"
                                                                                        :items="categories"
                                                                                        v-model="getItem.categoryId"
                                                                                        required>

                                                                                </v-select>

                                                                            </v-form>
                                                                        </v-card-text>
                                                                        <v-card-actions>
                                                                            <v-spacer></v-spacer>
                                                                            <v-btn    @click="">Cancel

                                                                            </v-btn>
                                                                            <v-btn color="primary" :disabled="!itemValid || loading" @click="createItem">Create and Add Item
                                                                                <v-icon v-if="itemLoading">fas fa-circle-notch fa-spin</v-icon>
                                                                            </v-btn>

                                                                        </v-card-actions>
                                                                    </v-card>
                                                                </v-expansion-panel-content>
                                                        </v-expansion-panel>-->

                                                </v-card-text>
                                            </v-card>
                                        </v-menu>
                                    </v-layout>
                                </template>
                            </td>
                            </tr>
                            <tr v-if="sale.saleDetails.length >= 1">
                                <td colspan="5"  >
                                    Total
                                </td>

                                <td>
                                    {{totalAmount}}
                                </td>
                            </tr>
                        </template>
                    </v-data-table>


                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn    @click="$router.go(-1)">Cancel

                </v-btn>
                <v-btn color="primary" :disabled="!valid || loading" @click="saveSale">{{actionTitle}}
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
        name: "Sale",
        props:['msg','id'],
        components: {
            'alert-box':AlertBox,
            VueEditor
        },
        data(){
            return {
                alert:false,
                valid:true,

                selectedItem:{},
                headers: [
                    {text: 'SN', sortable:true, value: 'sn'},
                    {text: 'Item',sortable:true, value: 'item'},
                    {text: 'Category',sortable:true, value: 'category'},
                    {text: 'Quantity',sortable:true, value: 'quantity'},
                    {text: 'Price', sortable:true,value: 'price'},
                    {text: 'Total Amount',sortable:true, value: 'totalPrice'},
                    {text: '', value: 'action'},
                ],
                sale: {
                    id:'',
                    narration:'',
                    totalPrice: '',
                    saleDetails: []
                },
                saleDetail: {
                    id:'',
                    itemId:'',
                    name: '',
                    categoryName:'',
                    quantity:1,
                    price:'',
                    totalPrice: ''
                },
                // for autocomplete
                descriptionLimit: 60,
                entries: [],
                isLoading: false,
                model: [],
                search: null,
                // for create item
                itemValid :true,
                itemLoading:'',
                // menu
                addItemMenu : false,

            }
        },
        created: function(){
            this.fetchSale();
            this.fetchCategories();

        },
        mounted(){

        },
        computed: {
            ...mapGetters([
                'loading','getSales','getSale','getCategories','getItems','getItem'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            pageTitle(){
                return this.sale.id !== '' || null ? 'Edit '+ this.sale.narration: 'Create New Sale';
            },
            actionTitle(){
                return this.sale.id !== '' || null ? 'Save': 'Create'
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

            items() {
                return this.entries;
            },
            totalQuantity() {
                if(!this.sale.saleDetails) return 0;
                return this.sale.saleDetails.reduce(function (total,value){
                    return total + value.quantity;
                },0);
            },
            totalAmount() {
                if(!this.sale.saleDetails) {
                    this.sale.totalPrice = 0;
                    return 0;
                }
                let total = this.sale.saleDetails.reduce(function (total,value){
                    return total + (value.quantity * value.price);
                },0);
                this.sale.totalPrice = total;
                return total;
            },
            billType(){
                return [
                    {text:'PAN',value:'PAN'},
                    {text:'VAT',value:'VAT'},
                    {text:'ESTIMATE',value:'ESTIMATE'},
                    {text:'BILL_FIRM',value:'BILL_FIRM'},
                    {text:'PAYMENT_SHEET',value:'PAYMENT_SHEET'},
                    {text:'SALARY_SHEET',value:'SALARY_SHEET'},
                ]
            }

        },
        watch: {
            search(val){
                //Item have already been loaded
                if(this.items.length > 0) return

                //Item have already been requested
                if(this.isLoading) return

                this.isLoading = true

                //Lazily load input items
                this.$store.dispatch('fetchItems')
                    .then(response => {
                        this.entries = response.data;
                    })
                    .catch(err =>{
                        console.log(err)
                    })
                    .finally(()=> (this.isLoading =false))
            },
            model(val,oldval) {
                // if old val is null return 0 else getting the changes value only
                const index = oldval == null? 0 : val.findIndex(function (v, i) {
                    return v !== oldval[i]
                }) ;
                if(index >=0) {
                    this.sale.saleDetails.push(
                        {

                            itemId: val[index].id,
                            name: val[index].name,
                            categoryName: val[index].category != null ? val[index].category.name : '',
                            price: val[index].price,
                            quantity: 1
                        }
                    );

                    // this is hack for closing autocomplete select once selected
                    setTimeout(() => {
                        this.$refs.autoComplete.isMenuActive = false;
                        this.addItemMenu = false;

                        //setting focus for new item
                        this.$refs[`item${val[index].id}`].focus();

                    },50);

                }
            },


        },
        methods:{
            ...mapActions([
                'fetchCategories'
            ]),
            fetchSale(){
                // if id has value it is edit other wise looking for create value
                if(this.id) {
                    if(this.id === 'create'){
                        // it will be used for create
                    }
                    else {
                        var app = this;
                        this.$store.dispatch('fetchSale', {id: this.id})
                            .then(response => {
                                app.sale.id = response.data.id;
                                app.sale.narration = response.data.narration;
                                app.sale.totalPrice = response.data.totalPrice;
                                //for details
                                response.data.saleDetails.forEach(detail => {
                                  app.sale.saleDetails.push({
                                      'id':detail.id,
                                      'itemId' : detail.item.id,
                                      'name': detail.item.name,
                                      'categoryName': detail.category != null? detail.category.name:'',
                                      'price': detail.price,
                                      'quantity': detail.quantity
                                  })
                                })
                            })
                    }
                }
            },
            saveSale(item){
                this.$store.dispatch('saveSale',this.sale)
                    .then(response => {

                        this.$router.push({path: '/dashboard/sales'/*, query: { status: response.data.message}*/});

                })
                    .catch(error => {
                        console.log(error);
                    });
            },
            addRow(){
                this.sale.saleDetails.push(
                    {
                        id: '1',name:'test',categoryName:'cements',quantity:'1',price:'500',totalPrice:'500'
                    }
                )
            },
            removeItem(item){

                const modelIndex= this.model.findIndex(x => x.id === item.itemId);
                //remove  item from model of autocomplete
                if(modelIndex >= 0 ) this.model.splice(modelIndex,1);

                //remove item from  model of table also
                const tableIndex = this.sale.saleDetails.indexOf(item);
                if(tableIndex >= 0) this.sale.saleDetails.splice(tableIndex,1);

            },
            createItem(){
                this.$store.dispatch('saveItem',this.getItem)
                    .then(response => {
                        //add the newly created item to entries of autocomplete and model of auto complete which will

                        // fetching item from created id

                        this.$store.dispatch('fetchItem',{id: response.data.created_id})
                            .then(res => {
                                //adding to entries
                                //this.entries.push(res.data);
                                this.model.push(res.data);
                                //watch doesnot work so adding manually
                                this.sale.saleDetails.push({
                                    id: '',
                                    itemId: res.data.id,
                                    name: res.data.name,
                                    categoryName: res.data.category != null ? res.data.category.name : '',
                                    price: res.data.price,
                                    quantity: 1
                                });

                                //close the menu
                                this.addItemMenu = false;
                                // setting input field focused
                                setTimeout(()=> {
                                    this.$refs[`item${res.data.id}`].focus();
                                },50);

                                //clear the current item
                                this.$store.dispatch('clearItem');



                            })

                    })
            }


        }
    }
</script>

<style scoped>

</style>
