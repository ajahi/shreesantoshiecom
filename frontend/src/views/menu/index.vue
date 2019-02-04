<template>
    <el-row>
        <el-col :xs="24" :sm="12" :md="12" :lg="12" style="padding: 10px">
            <el-tree
                    :data="menu"
                    node-key="id"
                    :props="defaultProps"
                    @node-drag-end="handleDragEnd"
                    @node-click="handleedit"
                    @node-drag-start="handleDragStart"
                    draggable
                    :allow-drop="allowDrop"
                    :allow-drag="allowDrag">
            </el-tree>
        </el-col>
        <el-col :xs="24" :sm="12" :md="12" :lg="12"  class="form-col">
            <el-form :rules="rules" ref="dataForm" :model="temp" label-position="left" label-width="100px"
              class="menu-form">
                <h2 style="color: #1f2d3d !important; font-variant: all-petite-caps; font-size: 30px">
                    {{textMap[dialogStatus]}}</h2>

                <el-form-item label="Title" prop="title" class="form-label">
                    <el-input v-model="temp.title"></el-input>
                </el-form-item>

                <el-form-item label="Description" prop="description" class="form-label">
                    <el-input v-model="temp.description"></el-input>
                </el-form-item>
                <el-form-item v-if="edit" label="Position" prop="position" class="form-label">
                    <el-input v-model="temp.position"></el-input>
                </el-form-item>

                <el-form-item label="Parent" prop="parent_id" class="form-label">
                    <el-select v-model="temp.parent_id" placeholder="please select Parent">
                        <el-option  v-for="item in  data" :key="item.id" :label="item.title" :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <img :src="temp.photo" height="200px">
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>


            </el-form>
            <el-row type="flex" class="row-bg" justify="center">
                <el-button v-if="dialogStatus==='create'" type="primary" @click="createData" style="width:33%; margin-top: 1rem; margin-bottom: 1rem;">Add</el-button>
                <el-button v-else type="primary" @click="updateData" style="width:45%; margin-top: 1rem; margin-bottom: 1rem;">Edit</el-button>
            </el-row>
        </el-col>

        <el-col :offset="4" :span="16">

            <!--filter-->
            <div class="filter-container">
                <el-input @keyup.enter.native="handleFilter" style="width: 200px;" class="filter-item" placeholder="keyword"
                          v-model="search">
                </el-input>

            </div>

            <!--Starting of table-->
            <el-table :data="filteredList"  element-loading-text="Loading" border fit
                      highlight-current-row style="width: 100%;margin-top: 10px;margin-bottom: 10px">

                <el-table-column align="center" label='ID' width="95">
                    <template slot-scope="scope">
                        {{scope.$index + 1}}
                    </template>
                </el-table-column>
                <el-table-column align="center" label="Title" >
                    <template slot-scope="scope">
                        {{scope.row.title}}
                    </template>
                </el-table-column>
                <el-table-column align="center" label="Parent" >
                    <template slot-scope="scope">
                        <span v-if="scope.row.parent">{{scope.row.parent.title}}</span>
                    </template>
                </el-table-column>



                <el-table-column align="center" label="Action" width="160">
                    <template slot-scope="scope">

                        <el-button type="primary" size="mini" style="margin: 2px" @click=" handleedit(scope.row)">Edit
                        </el-button>

                    </template>
                </el-table-column>

            </el-table>
            <!--End of table listing-->

        </el-col>
    </el-row>
</template>

<script>
    import waves from '../../directive/waves/index.js'

    export default {
        directives: {
            waves
        }, data() {
            return {

                search: '',

                menu: null,
                data: null,
                defaultProps: {
                    children: 'children',
                    label: 'title'
                },
                dialogStatus: 'create',
                textMap: {
                    update: 'Edit',
                    create: 'Create'
                },
                edit:false,
                file: null,
                temp: {
                    id: undefined,
                    title: '',
                    parent_id: undefined,
                    position: undefined,
                    description:'',
                    photo: null
                },
                rules: {
                    title: [{required: true, message: 'title is required', trigger: 'blur'}],
                    description: [{required: true, message: 'description is required', trigger: 'blur'}],

                }
            };
        },
        created() {
            this.getList()
        },
        computed: {
            filteredList() {

                if(this.data){
                    return this.data.filter(menu => {
                        return menu.title.toLowerCase().includes(this.search.toLowerCase())
                    })
                }


            }
        },
        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            getList() {
                this.$axios.get("/menu", { params:{
                    "parent_id": 1
                }}).then(response => {
                    this.menu = response.data.data;
                })
                this.$axios.get("/menu").then(response => {
                    this.data = response.data.data;
                })
            },
            resetTemp() {
                this.temp = {
                    id: undefined,
                    title: '',
                    parent_id: null,
                    photo: null,
                    position: undefined,
                    description: ''
                }
                this.dialogStatus = "create";
                this.file = null;

            },
            createData() {
                this.$refs['dataForm'].validate((valid) => {
                    if (valid) {
                        var formData = new FormData();
                        if (this.temp.id) {

                            formData.append('id', this.temp.id);
                        }
                        formData.append('title', this.temp.title);
                        formData.append('description', this.temp.description);

                        if (this.temp.parent_id) {
                            formData.append('parent_id', this.temp.parent_id);
                        }


                        if (this.file) {
                            formData.append('image', this.file);
                        }

                        this.$axios.post("/menu/", formData).then(() => {
                            this.getList();
                            this.resetTemp();
                            this.$message({
                                type: 'success',
                                message: 'Category Creation completed'
                            });
                        })
                    }
                })
            },
            updateData() {
                this.$refs['dataForm'].validate((valid) => {
                    if (valid) {
                        var formData = new FormData();
                        if (this.temp.id) {

                            formData.append('id', this.temp.id);
                        }
                        formData.append('title', this.temp.title);
                        formData.append('position', this.temp.position);
                        formData.append('description', this.temp.description);

                        if (this.temp.parent_id) {
                            formData.append('parent_id', this.temp.parent_id);
                        }
                        if (this.file) {
                            formData.append('image', this.file);
                        }
                        formData.append('_method', "put");

                        this.$axios.post("/menu/" + this.temp.id, formData).then(() => {

                            this.getList();
                            this.resetTemp();
                            this.$message({
                                type: 'success',
                                message: 'Category update completed'
                            });
                            this.edit = false;
                            this.resetTemp();

                        })
                    }
                })
            },
            handleedit(node) {
                this.dialogStatus = "update";
                this.temp.id = node.id;
                this.temp.title = node.title;
                this.temp.parent_id = node.parent_id;
                this.temp.position = node.position;
                this.temp.description = node.description;

                this.temp.photo = node.photo;
                this.edit = true;


            },
            handleDragStart(node, ev) {
            },
            handleDragEnter(draggingNode, dropNode, ev) {
            },
            handleDragLeave(draggingNode, dropNode, ev) {
            },
            handleDragOver(draggingNode, dropNode, ev) {
            },
            handleDragEnd(draggingNode, dropNode, dropType, ev) {

                this.$axios.post("/menu", {
                    "_method":"put",
                    "type": dropType,
                    "id": draggingNode.data.id,
                    "parent_id": dropNode.data.id
                }).then(response => {
                    this.menu = response.data.data
                })

            },
            handleDrop(draggingNode, dropNode, dropType, ev) {

            },
            allowDrop() {
                return true;
            },
            allowDrag() {
                return true;
            }
        }
    };
</script>

<style>

    .el-tree-node__content {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        height: 26px;
        cursor: pointer;
        padding: 20px;
        background-color: #009688;
        margin: 5px;
        color: #ffffff;
        font-size: 40px !important;
        font-variant: all-petite-caps;
    }
     .form-col {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    }
    .menu-form {
        width: 90%;
        margin-left:50px;
    }

    @media (min-width: 767px) and (max-width: 1000px){
    .form-label  {
        width: 90%;
        }
    }
    @media (min-width: 320px) and (max-width: 500px){
    .menu-form {
        padding-left: 1.5rem;
        margin-left:0px;
    }
    }


</style>