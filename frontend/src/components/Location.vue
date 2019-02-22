<template>
    <v-container >
        <v-card class="elevation-12">
            <v-toolbar color="white">
                <v-toolbar-title>Create/Edit/Delete Location</v-toolbar-title>
                <v-spacer></v-spacer>

                <v-dialog v-model="dialog" max-width="500px" >
                    <v-btn slot="activator" color="primary " dark class="mb-2" >Create New Location</v-btn>


                    <v-form ref="location" v-model="valid">
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ dialogTitle }}</span>
                            </v-card-title>
                            <alert-box />

                            <v-card-text>
                                <v-form ref="location" v-model="valid" >
                                    <input type="hidden" v-model="location.id" />
                                    <v-layout justify-space-between row>
                                        <v-flex>
                                            <v-text-field
                                                    prepend-icon="male"
                                                    name="buildingNo"
                                                    label="Building No "
                                                    id="buildingNo"
                                                    type="text"
                                                    v-model="location.buildingNo"
                                            ></v-text-field>
                                        </v-flex>
                                        <v-flex>
                                            <v-text-field
                                                    prepend-icon="face"
                                                    name="streetName"
                                                    label="Street Name"
                                                    id="streetName"
                                                    type="text"
                                                    v-model="location.streetName"
                                            ></v-text-field>
                                        </v-flex>
                                    </v-layout>

                                    <v-layout justify-space-between row>

                                        <v-text-field
                                                prepend-icon="person"
                                                name="city"
                                                label="City *"
                                                id="city"
                                                type="text"
                                                v-model="location.city"
                                        ></v-text-field>
                                        <v-spacer></v-spacer>
                                        <v-text-field
                                                prepend-icon="person"
                                                name="state"
                                                label="state *"
                                                id="state"
                                                type="text"
                                                v-model="location.state"
                                        ></v-text-field>
                                        <v-spacer></v-spacer>
                                        <v-text-field
                                                prepend-icon="person"
                                                name="zipcode"
                                                label="Zip Code *"
                                                id="zipcode"
                                                type="text"
                                                v-model="location.zipcode"
                                        ></v-text-field>
                                    </v-layout>

                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" :disabled="!valid || loading"  flat @click.native="saveLocation">{{ actionTitle}}  <v-icon v-if="loading">fas fa-circle-notch fa-spin</v-icon></v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>

                </v-dialog>

            </v-toolbar>

            <alert-box />
            <v-data-table
                    :items="getLocations"
                    :headers="headers">
                <template slot="items" slot-scope="props">

                    <td>{{ props.index + 1  }}</td>
                    <td>{{ props.item.city }}</td>
                    <td>{{ props.item.state }}</td>
                    <td>{{ props.item.zipcode }}</td>
                    <td>{{ props.item.streetName }}</td>
                    <td>{{ props.item.buildingNo }}</td>
                    <td class="justify-center layout px-0">
                        <v-icon small class="mr-2" @click="editLocation(props.item)" >
                            edit
                        </v-icon>
                        <v-icon small class="mr-2" @click="deleteLocation(props.item)">
                            delete
                        </v-icon>
                    </td>
                </template>

                <template slot="no-data">
                    <v-alert :value="true" color="error" icon="warning">
                        Sorry, No Location Yet.
                    </v-alert>
                </template>

            </v-data-table>



        </v-card>
    </v-container>
</template>


<script>
    import { mapGetters} from 'vuex';
    //import AlertBox from 'src/components/AlertBox';
    import AlertBox from './shared/AlertBox';
    import Confirm from "./shared/Confirm";

    export default {
        name: 'Location',
        props: {
            msg: String
        },
        components: {
            Confirm,
           'alert-box': AlertBox
        },
        data() {
            return {
                alert: false,
                valid:true,
                headers: [
                    {text: 'SN',value:'sn'},
                    {text: 'City', sortable: false, value:'city'},
                    {text: 'State', sortable:false,value:'state'},
                    {text: 'Zip code', sortable:false,value:'zipcode'},
                    {text: 'Steet Name', sortable:false,value:'streetName'},
                    {text: 'Building No', sortable:false,value:'buildingName'},
                ],
                location: {
                    id: '',
                    city: '',
                    state: '',
                    zipcode: '',
                    buildingNo: '',
                    streetName: '',
                    latitude: '',
                    longitude: '',

                },
                dialog: false,
                createFlag: false,

            }
        },
        created: function(){
            this.$store.commit('setLayout','app-layout');
            this.$store.dispatch('fetchLocations');
        },
        mounted(){

        },
        computed: {
            ...mapGetters([
                'loading','getLocations'
            ]),
            loading(){
                return this.$store.getters.loading;
            },
            dialogTitle(){
                return this.location.id != null || '' ? 'Edit Location' : 'Create Location'

            },
            actionTitle(){
                return this.location.id != null || '' ? 'Save' : 'Create'
            }
        },
        watch: {
            dialog(value){
                if(!value){
                    this.location = {};
                    this.createFlag = false;
                }
            }

        },
        methods: {
            saveLocation(){
                if(this.$refs.location.validate()){
                    //console.log(this.location);
                    this.$store.dispatch('saveLocation',this.location)
                        .then(response => {
                            if(response.data.created_id){
                                this.location.id = response.data.created_id;
                            }
                        })
                }
            },
            deleteLocation(location){
                this.$root.$confirm('Delete','Are you sure', {color: 'red'}).then((confirm) =>
                    {
                        if(confirm){
                            this.$store.dispatch('deleteLocation',location.id);
                        }
                    }
                    );
            },
            editLocation(location){
                this.setSelectedLocation(location);
                this.dialog = true;
            },
            setSelectedLocation(location){
                /*console.log(location);
                this.location.id = location.id;
                this.location.state = location.state;
                this.location.city = location.city;
                this.location.zipcode = location.zipcode;*/
                this.location = location;

            }
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
