<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>Create/Edit/Delete Purchase</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-toolbar-items>
                    <v-btn to="/dashboard/purchase/create" flat>Create a Purchase</v-btn>
                    <!--<v-btn flat @click="expandFilter">Filter</v-btn>-->
                    <download-excel
                            :data="getPurchases"
                            :fields="exportFields"
                            :name="excelFileName"
                            class="height-inherit">
                        <v-btn flat>Download as Excel  &nbsp; <v-icon>fa-file-excel</v-icon></v-btn>
                    </download-excel>

                </v-toolbar-items>

            </v-toolbar>
            <alert-box  />

            <v-expansion-panel
             v-model="filter"
            toggle>
                <v-expansion-panel-content
                v-for="(item,i) in expandable" :key="i">
                    <div slot="default" ></div>
                    <v-card>
                        <v-card-text>
                            <v-layout justify-space-between column>
                                <v-layout>

                                    <v-flex>
                                        <v-label>Please select the Date range for purchase report</v-label>
                                        <v-daterange
                                                :options="dateRangeOptions"
                                                @input="onDateRangeChange"
                                        ></v-daterange>
                                        <v-btn  color="primary">Search</v-btn>
                                    </v-flex>

                                </v-layout>
                            </v-layout>
                            <hr />

                        </v-card-text>
                    </v-card>
                </v-expansion-panel-content>
            </v-expansion-panel>
            <v-data-table
                    :items="getPurchases"
                    :headers="headers">
                <template slot="items" slot-scope="props">
                    <td>{{ props.index + 1  }}</td>
                    <td>{{ props.item.narration }}</td>
                    <td>{{ props.item.voucherNo }}</td>
                    <td>{{ props.item.totalPrice }}</td>
                    <td>{{ props.item.billNature }}</td>
                    <td>{{ props.item.date }}</td>
                    <td class="justify-center layout px-0">
                        <router-link :to="{name: 'purchase',params: {id: props.item.id}}">
                            <v-icon small class="mr-2" @click="" >
                                edit
                            </v-icon>
                        </router-link>
                        <v-icon @click="deletePurchase(props.item)" small>
                            delete
                        </v-icon>
                    </td>
                </template>

                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        Sorry, No Purchase Yet.
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
    import { format, subDays, addDays } from 'date-fns';

    export default {
        name: "PurchaseList",
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
                    {text: 'Narration', sortable: false, value:'narration'},
                    {text: 'Voucher No', sortable: false, value:'voucherNo'},
                    {text: 'Total Price', sortable: false, value:'totalPrice'},
                    {text: 'Bill Nature', sortable: false, value:'billNature'},
                    {text: 'Date', sortable: false, value:'date'},
                    {text: 'Actions', sortable: false, value:'action'},
                ],
                selectedItem:{},
                snackbar:false,
                snackbarMsg:'',
                filter:1,
                expandable:1,
                range: [],
                dateRangeOptions: {
                    startDate: format(new Date(), 'YYYY-MM-DD'),
                    endDate: format(new Date(), 'YYYY-MM-DD'),
                    format: 'YYYY-MM-DD',
                    presets: [
                        {
                            label: 'Today',
                            range: [
                                format(new Date(), 'YYYY-MM-DD'),
                                format(new Date(), 'YYYY-MM-DD'),
                            ],
                        },
                        {
                            label: 'Yesterday',
                            range: [
                                format(subDays(new Date(), 1), 'YYYY-MM-DD'),
                                format(subDays(new Date(), 1), 'YYYY-MM-DD'),
                            ],
                        },
                        {
                            label: 'Last 7 Days',
                            range: [
                                format(subDays(new Date(), 7), 'YYYY-MM-DD'),
                                format(subDays(new Date(), 1), 'YYYY-MM-DD'),
                            ],
                        },
                        {
                            label: 'Last 30 Days',
                            range: [
                                format(subDays(new Date(), 30), 'YYYY-MM-DD'),
                                format(subDays(new Date(), 1), 'YYYY-MM-DD'),
                            ],
                        },
                    ],
                },
                exportFields:{
                    'ID':'id',
                    'Narration':'narration',
                    'VoucherNo':'voucherNo',
                    'Total Price':'totalPrice',
                    'Bill Nature':'billNature',
                    'Date':'date',
                    'Supplier':{
                        field:'supplier',
                        callback: (value) => value !== null?value.id+'|'+value.name:''
                    }
                }
            }
        },
        created: function(){
            var app = this;
            this.$store.dispatch('fetchPurchases').then(response => {
                // this will be called only if purchase item is being edited or created from another component
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
                'loading','getPurchases','getAlertMsg','getAlertType'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            /*excelFileName(){
                return 'Purchase List from'+this.range[0]+'to'+this.range[1]+' .xlsx'
            },*/
            excelFileName(){
                return 'Purchase List'+new Date().toDateString()+' .xlsx'
            }
        },
        watch: {


        },
        methods:{
            editItem(item){

            },
            deleteItem(item){
                this.$root.$confirm('Delete ' +item.narration,'Are you sure?',{color:'red'})
                    .then((confirm) => {
                        if(confirm){
                            //if true, call delete end point
                            this.$store.dispatch('deletePurchase',item.id)
                                .then(response =>{

                                })
                        }
                        else{

                        }
                    })
            },
            expandFilter(){
                    if(this.filter ===1){
                        this.filter = 0;
                    }
                    else{
                        this.filter = 1;
                    }


            },
            onDateRangeChange(range) {
                this.range = range;
            },



        }
    }
</script>

<style scoped>
    .height-inherit{
        height: inherit;
    }

</style>
