<template>
    <div class="app-container">

        <div class="filter-container">
            <el-input @keyup.enter.native="handleFilter" style="width: 200px;" class="filter-item" placeholder="keyword"
                      v-model="listQuery.name">
            </el-input>
            <!--<el-select clearable style="width: 90px" class="filter-item" v-model="listQuery.importance" :placeholder="$t('table.importance')">-->
            <!--<el-option v-for="item in importanceOptions" :key="item" :label="item" :value="item">-->
            <!--</el-option>-->
            <!--</el-select>-->
            <!--&lt;!&ndash;<el-select clearable class="filter-item" style="width: 130px" v-model="listQuery.type" :placeholder="$t('table.type')">&ndash;&gt;-->
            <!--&lt;!&ndash;<el-option v-for="inp,mtem in  calendarTypeOptions" :key="item.key" :label="item.display_name+'('+item.key+')'" :value="item.key">&ndash;&gt;-->
            <!--&lt;!&ndash;</el-option>&ndash;&gt;-->
            <!--&lt;!&ndash;</el-select>&ndash;&gt;-->
            <el-select @change='handleFilter' style="width: 140px" class="filter-item" v-model="listQuery.sort">
                <el-option v-for="item in sortOptions" :key="item.key" :label="item.label" :value="item.key">
                </el-option>
            </el-select>

            <el-button class="filter-item" type="primary" v-waves icon="el-icon-search" @click="handleFilter">Search
            </el-button>
            <el-button class="filter-item" style="margin-left: 10px;" @click="handleCreate" type="primary"
                       icon="el-icon-edit">Create
            </el-button>

            <el-button class="filter-item" style="margin-left: 10px;" @click="reload" type="info"
            >Reload
            </el-button>
            <!--<el-button class="filter-item" type="primary" :loading="downloadLoading" v-waves icon="el-icon-download" @click="handleDownload">{{$t('table.export')}}</el-button>-->
            <!--<el-checkbox class="filter-item" style='margin-left:15px;' @change='tableKey=tableKey+1' v-model="showReviewer">{{$t('table.reviewer')}}</el-checkbox>-->
        </div>


        <el-table :data="list" v-loading.body="listLoading" element-loading-text="Loading" border fit
                  highlight-current-row style="width: 100%;margin-top: 10px;margin-bottom: 10px">
            <el-table-column align="center" label='ID' width="95">
                <template slot-scope="scope">
                    {{scope.$index}}
                </template>
            </el-table-column>


            <el-table-column label="Image">
                <template slot-scope="scope">
                    <img width="100%" :src="scope.row.image"/>
                </template>
            </el-table-column>

            <el-table-column label="Title">
                <template slot-scope="scope">
                    {{scope.row.title}}
                </template>
            </el-table-column>
            <el-table-column label="Link" align="center">
                <template slot-scope="scope">
                    <span>{{scope.row.link}}</span>
                </template>
            </el-table-column>



            <el-table-column align="center" label="Action" width="250" class-name="small-padding fixed-width">
                <template slot-scope="scope">

                    <el-button type="primary" size="mini" @click="handleUpdate(scope.row)">Edit</el-button>

                    <el-button size="mini" type="danger"
                               @click="handleDelete(scope.row)">Delete
                    </el-button>
                </template>
            </el-table-column>

        </el-table>

        <div class="pagination-container">
            <el-pagination background @size-change="handleSizeChange" @current-change="handleCurrentChange"
                           :current-page="listQuery.page" :page-sizes="[50,100,150, 200]" :page-size="listQuery.limit"
                           layout="total, sizes, prev, pager, next, jumper" :total="total">
            </el-pagination>
        </div>

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
            <el-form :rules="rules" ref="dataForm" :model="temp" label-position="left" label-width="100px"
                     style='width: 400px; margin-left:50px;'>

                <el-form-item label="Title" prop="title">
                    <el-input v-model="temp.title"></el-input>
                </el-form-item>

                <el-form-item label="Link" prop="link">
                    <el-input v-model="temp.link"></el-input>
                </el-form-item>

                <img :src="temp.image" height="200px">
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Cancel</el-button>
                <el-button v-if="dialogStatus=='create'" type="primary" @click="createData">Confirm</el-button>
                <el-button v-else type="primary" @click="updateData">Confirm</el-button>
            </div>
        </el-dialog>

    </div>
</template>

<script>

    import waves from '../../directive/waves/index.js'

    export default {
        directives: {
            waves
        },        data() {

            return {
                total: null,
                list: null,
                listLoading: true,
                file:null,
                listQuery: {
                    page: 1,
                    limit: 50,
                    title: undefined,
                    sort: 'desc'
                },
                sortOptions: [{label: 'Ascending', key: 'asc'}, {label: 'Descending', key: 'desc'}],
                dialogFormVisible: false,
                dialogStatus: '',
                textMap: {
                    update: 'Edit',
                    create: 'Create'
                },

                temp: {
                    id: undefined,
                    title: '',
                    link: '',
                    image: null
                },
                rules: {
                    title: [{required: true, message: 'title is required', trigger: 'change'}],
                    link: [{ required: true, message: 'link is required', trigger: 'blur'}],
                }


            }
        },
        filters: {

        },
        created() {
            this.getList()
        },
        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            getList() {
                this.listLoading = true
                this.$axios.get("/slide", {params: this.listQuery}).then(response => {
                    console.log(response.data)
                    this.list = response.data.data;
                    this.total = response.data.meta.total;

                    setTimeout(() => {
                        this.listLoading = false
                    }, 1.5 * 1000)
                })
            },
            reload() {
                this.listQuery = {
                    page: 1,
                    limit: 50,
                    title: undefined,
                    sort: 'desc'
                };
                this.file = null;
                this.getList()
            },
            createData() {
                this.$refs['dataForm'].validate((valid) => {
                    if (valid) {
                        var formData = new FormData();
                        if (this.temp.id) {

                            formData.append('id', this.temp.id);
                        }
                        formData.append('title', this.temp.title);
                        if (this.temp.link) {
                            formData.append('link', this.temp.link);
                        }
                        if(this.file){
                            formData.append('image', this.file);
                        }

                        this.$axios.post("/slide/", formData).then(response => {
                            this.list.unshift(response.data.data)
                            this.dialogFormVisible = false
                            this.$message({
                                type: 'success',
                                message: 'Slide Creation completed'
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
                        if (this.temp.link) {
                            formData.append('link', this.temp.link);
                        }
                        if(this.file){
                            formData.append('image', this.file);
                        }
                        formData.append('_method', "put");

                        this.$axios.post("/slide/" + this.temp.id, formData).then(response => {
                            for (const v of this.list) {
                                if (v.id === this.temp.id) {
                                    const index = this.list.indexOf(v)
                                    this.list.splice(index, 1, response.data.data)
                                    break
                                }
                            }
                            this.dialogFormVisible = false
                            this.$message({
                                type: 'success',
                                message: 'Slide update completed'
                            });
                        })
                    }
                })
            },
            resetTemp() {
                this.temp = {
                    id: undefined,
                    title: '',
                    link: '',
                    image: null
                }
                this.file = null;
            },
            handleFilter() {
                this.listQuery.page = 1
                this.getList()
            },
            handleDelete(row) {
                this.$confirm('This will permanently delete. Continue?', 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    this.$axios.delete("/slide/" + row.id).then(response => {
                        const index = this.list.indexOf(row)
                        this.list.splice(index, 1)
                        this.$message({
                            type: 'success',
                            message: 'Delete completed'
                        });
                    })

                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });


            },
            handleSizeChange(val) {
                this.listQuery.limit = val
                this.getList()
            },
            handleCurrentChange(val) {
                this.listQuery.page = val
                this.getList()
            },

            handleCreate() {
                this.resetTemp()
                this.dialogStatus = 'create'
                this.dialogFormVisible = true
                this.$nextTick(() => {
                    this.$refs['dataForm'].clearValidate()
                })
            },
            handleUpdate(row) {
                this.temp = Object.assign({}, row)
                this.dialogStatus = 'update'
                this.dialogFormVisible = true
                this.$nextTick(() => {
                    this.$refs['dataForm'].clearValidate()
                })
            },
            handleStatus(row) {
                this.temp = Object.assign({}, row)
                this.temp["_method"] = "put";
                this.$axios.post("/slide/" + this.temp.id, this.temp).then(response => {
                    for (const v of this.list) {
                        if (v.id === this.temp.id) {
                            const index = this.list.indexOf(v)
                            this.list.splice(index, 1, response.data.data)
                            break
                        }
                    }
                    this.dialogFormVisible = false
                    this.$message({
                        type: 'success',
                        message: 'Slide update completed'
                    });
                })
            },


        }
    }
</script>
