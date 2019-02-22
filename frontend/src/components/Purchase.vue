<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>{{ pageTitle }}</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn to="/dashboard/purchases" flat>Go to PurchaseList</v-btn>
                </v-toolbar-items>

            </v-toolbar>
            <v-card-text>
                <v-form ref="item" v-model="valid">
                    <input type="hidden" v-model="purchase.id" />


                    <v-text-field prepend-icon="fa-passport" v-model="purchase.narration" label="Narration *"></v-text-field>
                    <v-layout row wrap>
                            <v-flex sm6 lg6>
                                <v-text-field  v-model="purchase.voucherNo" label="Voucher No"
                                              prepend-icon="fa-file-invoice "></v-text-field>
                            </v-flex>
                            <v-flex sm6 lg6>
                                <!--<v-text-field  v-model="purchase.billNature" label="Bill Nature"
                                              prepend-icon="layers"></v-text-field>-->
                                <v-select
                                :items="billType"
                                v-model="purchase.billNature"
                                label="Bill Nature"
                                prepend-icon="layers">

                                </v-select>
                            </v-flex>

                        <v-flex sm6 lg6>
                            <v-menu
                                    ref="dateMenu"
                                    :close-on-content-click="false"
                                    v-model="purchase.menu"
                                    :nudge-right="40"
                                    :return-value.sync="purchase.date"
                                    lazy
                                    transition="scale-transition"
                                    offset-y
                                    full-width
                                    min-width="290px"
                            >
                                <v-text-field
                                        slot="activator"
                                        v-model="purchase.date"
                                        label="Date of Transaction "
                                        prepend-icon="event"
                                        readonly
                                ></v-text-field>
                                <v-date-picker
                                        v-model="purchase.date"
                                        no-title
                                        scrollable
                                        :max="new Date().toISOString()"
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn flat color="primary" @click="dateMenu = false">Cancel</v-btn>
                                    <v-btn flat color="primary" @click="$refs.dateMenu.save(purchase.date)">OK</v-btn>
                                </v-date-picker>
                            </v-menu>
                        </v-flex>

                        <v-flex sm6 lg6>
                            <v-autocomplete
                                    v-model="purchase.supplierId"
                                    label="Select Supplier"
                                    :items="suppliers"
                                    :search-input.sync="supplierSearch"
                                    ref="supplier"
                                    prepend-icon="store"

                            >
                                <template slot="no-data">
                                    <flex>
                                        <v-label>No data found </v-label>
                                        <v-expansion-panel>
                                            <v-expansion-panel-content
                                                    v-for="i in 1" :key="i">
                                                <div slot="header"><v-btn flat block color="primary"> Create new Supplier and Add</v-btn></div>
                                                <supplier
                                                        external-use="true"
                                                        @created-supplier="updateSuppliersAndUpdateModel"
                                                ></supplier>

                                            </v-expansion-panel-content>
                                        </v-expansion-panel>

                                    </flex>
                                </template>
                            </v-autocomplete>

                        </v-flex>



                    </v-layout>
                    <!-- edit table for crud of item-->
                    <v-data-table
                        :headers="headers"
                        :items="purchase.purchaseDetails"
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
                                                        <v-expansion-panel  >
                                                                <v-expansion-panel-content
                                                                        v-for="(i) in 1"
                                                                        :key="i"
                                                                >
                                                                    <div slot="header" ><v-btn flat block color="primary">Or Create an Item & Add</v-btn></div>
                                                                    <v-card >
                                                                        <v-card-text>
                                                                            <v-form ref="item" v-model="itemValid">


                                                                                <v-text-field prepend-icon="fa-passport" v-model="getItem.name" label="Name *" required></v-text-field>
                                                                                <!--<v-label>Description</v-label>

                                                                                <vue-editor v-model="getItem.description"></vue-editor>-->
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
                                                            </v-expansion-panel>

                                                </v-card-text>
                                            </v-card>
                                        </v-menu>
                                    </v-layout>
                                </template>
                            </td>
                            </tr>
                            <tr v-if="purchase.purchaseDetails.length >= 1">
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
                <v-btn color="primary" :disabled="!valid || loading" @click="savePurchase">{{actionTitle}}
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
    import Supplier from "./Supplier";

    export default {
        name: "Item",
        props:['msg','id'],
        components: {
            Supplier,
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
                supplierSearch:'',
                purchase: {
                    id:'',
                    narration:'',
                    voucherNo:'',
                    totalPrice: '',
                    billNature:'',
                    date:new Date().toISOString().substr(0,10),
                    dateMenu:false,
                    purchaseDetails: [],
                    supplier:{},
                    supplierId:''
                },
                purchaseDetail: {
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
            this.fetchPurchase();
            this.fetchCategories();
            this.$store.dispatch('fetchSuppliers');


        },
        mounted(){

        },
        computed: {
            ...mapGetters([
                'loading','getPurchases','getPurchase','getCategories','getItems','getItem','getSuppliers'
            ]),
            ...mapActions([
                'fetchSuppliers'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            pageTitle(){
                return this.purchase.id !== '' || null ? 'Edit '+ this.purchase.narration: 'Create New Purchase';
            },
            actionTitle(){
                return this.purchase.id !== '' || null ? 'Save': 'Create'
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
            suppliers(){
                return this.getSuppliers.map(supplier => {
                    return {
                        text: supplier.name,
                        value: supplier.id
                    }
                })
            },

            items() {
                return this.entries;
            },
            totalQuantity() {
                if(!this.purchase.purchaseDetails) return 0;
                return this.purchase.purchaseDetails.reduce(function (total,value){
                    return total + value.quantity;
                },0);
            },
            totalAmount() {
                if(!this.purchase.purchaseDetails) {
                    this.purchase.totalPrice = 0;
                    return 0;
                }
                let total = this.purchase.purchaseDetails.reduce(function (total,value){
                    return total + (value.quantity * value.price);
                },0);
                this.purchase.totalPrice = total;
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
                    this.purchase.purchaseDetails.push(
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
            fetchPurchase(){
                // if id has value it is edit other wise looking for create value
                if(this.id) {
                    if(this.id === 'create'){
                        // it will be used for create
                    }
                    else {
                        var app = this;
                        this.$store.dispatch('fetchPurchase', {id: this.id})
                            .then(response => {
                                app.purchase.id = response.data.id;
                                app.purchase.narration = response.data.narration;
                                app.purchase.voucherNo = response.data.voucherNo;
                                app.purchase.totalPrice = response.data.totalPrice;
                                app.purchase.billNature = response.data.billNature;
                                app.purchase.date = response.data.date;
                                app.purchase.supplierId = response.data.supplier !== null?response.data.supplier.id:''
                                //for details
                                response.data.purchaseDetails.forEach(detail => {
                                  app.purchase.purchaseDetails.push({
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
            savePurchase(item){
                this.$store.dispatch('savePurchase',this.purchase)
                    .then(response => {

                        this.$router.push({path: '/dashboard/purchases'/*, query: { status: response.data.message}*/});

                })
                    .catch(error => {
                        console.log(error);
                    });
            },
            removeItem(item){

                const modelIndex= this.model.findIndex(x => x.id === item.itemId);
                //remove  item from model of autocomplete
                if(modelIndex >= 0 ) this.model.splice(modelIndex,1);

                //remove item from  model of table also
                const tableIndex = this.purchase.purchaseDetails.indexOf(item);
                if(tableIndex >= 0) this.purchase.purchaseDetails.splice(tableIndex,1);

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
                                this.purchase.purchaseDetails.push({
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
            },
            updateSuppliersAndUpdateModel(e){
                this.suppliers.push(e);
                setTimeout(()=>{
                    this.$refs.supplier.isMenuActive= false;
                    this.purchase.supplierId = e.id;

                },50);
            }


        }
    }
</script>

<style scoped>

</style>
