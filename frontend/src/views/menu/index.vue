<template>
    <el-row>
        <el-col :span="12" style="padding: 10px">
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
        <el-col :span="12" style="margin-top: 100px">

            <el-form :rules="rules" ref="dataForm" :model="temp" label-position="left" label-width="100px"
                     style='width: 400px; margin-left:50px;'>
                <h2 style="color: #1f2d3d !important; font-variant: all-petite-caps; font-size: 30px">
                    {{textMap[dialogStatus]}}</h2>

                <el-form-item label="Title" prop="title">
                    <el-input v-model="temp.title"></el-input>
                </el-form-item>

                <el-form-item label="Description" prop="description">
                    <el-input v-model="temp.description"></el-input>
                </el-form-item>
                <el-form-item label="Position" prop="position">
                    <el-input v-model="temp.position"></el-input>
                </el-form-item>

                <el-form-item label="Parent" prop="parent_id">
                    <el-select v-model="temp.parent_id" placeholder="please select Parent">
                        <el-option v-for="item in  data" :key="item.id" :label="item.title" :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <img :src="temp.photo" height="200px">
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
            </el-form>
            <el-row type="flex" class="row-bg" justify="center">
                <el-button v-if="dialogStatus==='create'" type="primary" @click="createData">Add</el-button>
                <el-button v-else type="primary" @click="updateData">Edit</el-button>
            </el-row>
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
                file: null,
                temp: {
                    id: undefined,
                    title: '',
                    parent_id: undefined,
                    position: null,
                    description:'',
                    photo: null
                },
                rules: {
                    title: [{required: true, message: 'title is required', trigger: 'blur'}],
                    position: [{required: true, message: 'position is required', trigger: 'blur'}],
                    description: [{required: true, message: 'description is required', trigger: 'blur'}],

                }
            };
        },
        created() {
            this.getList()
        },

        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            getList() {
                this.$axios.get("/menu", {
                    "parent_id": 1
                }).then(response => {
                    console.log(response.data)
                    this.menu = response.data.data;
                })
                this.$axios.get("/menu").then(response => {
                    console.log(response.data)
                    this.data = response.data.data;
                })
            },
            resetTemp() {
                this.temp = {
                    id: undefined,
                    title: '',
                    parent_id: null,
                    photo: null,
                    position: null,
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
                        formData.append('position', this.temp.parent_id);


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
                        })
                    }
                })
            },
            handleedit(node) {
                this.dialogStatus = "update";
                this.temp.id = node.id;
                this.temp.title = node.title;
                this.temp.parent_id = node.parent_id;
                this.temp.photo = node.photo;

                console.log('Node Click', node);

            },
            handleDragStart(node, ev) {
                console.log('drag start', node);
            },
            handleDragEnter(draggingNode, dropNode, ev) {
                console.log('tree drag enter: ', dropNode.label);
            },
            handleDragLeave(draggingNode, dropNode, ev) {
                console.log('tree drag leave: ', dropNode.label);
            },
            handleDragOver(draggingNode, dropNode, ev) {
                console.log('tree drag over: ', dropNode.label);
            },
            handleDragEnd(draggingNode, dropNode, dropType, ev) {
                console.log(draggingNode.data.id, dropNode.data.id, dropType);

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

                console.log('parent id of  ', draggingNode, 'is', dropNode, dropType);
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

</style>