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
            <el-select @change='handleFilter' style="width: 140px" class="filter-item" v-model="listQuery.status">
                <el-option v-for="item in statusOptions" :key="item" :label="item" :value="item">
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
            <el-table-column label="Name">
                <template slot-scope="scope">
                    {{scope.row.name}}
                </template>
            </el-table-column>
            <el-table-column label="Email" align="center">
                <template slot-scope="scope">
                    <span>{{scope.row.email}}</span>
                </template>
            </el-table-column>

            <el-table-column label="Role" align="center" width="100">
                <template slot-scope="scope">
                    <span>{{scope.row.roles[0].display_name}}</span>
                </template>
            </el-table-column>
            <el-table-column class-name="status-col" label="Status" width="100">
                <template slot-scope="scope">
                    <el-tag :type="scope.row.verified | statusFilter">{{scope.row.verified | verifiedFilter}}</el-tag>
                </template>
            </el-table-column>

            <el-table-column align="center" label="Action" width="250" class-name="small-padding fixed-width">
                <template slot-scope="scope">
                    <el-button :type="scope.row.status | statusFilter" @click="handleStatus(scope.row)" size="mini">
                        {{scope.row.status}}
                    </el-button>

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

                <el-form-item label="Name" prop="name">
                    <el-input v-model="temp.name"></el-input>
                </el-form-item>

                <el-form-item label="Email" prop="email">
                    <el-input type="email" v-model="temp.email"></el-input>
                </el-form-item>

                <el-form-item label="Role" prop="role_id">
                    <el-select v-model="temp.role_id" placeholder="please select role">
                        <el-option v-for="item in  roles" :key="item.id" :label="item.display_name" :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>

                <el-form-item label="Password" prop="password">
                    <el-input type="password" v-model="temp.password"></el-input>
                </el-form-item>
                <el-form-item label="Confirm" prop="password_confirmation">
                    <el-input type="password" v-model="temp.password_confirmation" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="Status">
                    <el-select class="filter-item" v-model="temp.status" placeholder="Please select">
                        <el-option v-for="item in  statusOptions" :key="item" :label="item" :value="item">
                        </el-option>
                    </el-select>
                </el-form-item>

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
        },
        data() {
            var confirmpassword = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('Please input the password again'));
                } else if (value !== this.temp.password) {
                    callback(new Error('Two inputs don\'t match!'));
                } else {
                    callback();
                }
            };


            return {
                total: null,
                list: null,
                roles: null,
                listLoading: true,
                listQuery: {
                    page: 1,
                    limit: 50,
                    status: undefined,
                    name: undefined,
                    type: undefined,
                    sort: 'desc'
                },
                sortOptions: [{label: 'Ascending', key: 'asc'}, {label: 'Descending', key: 'desc'}],
                statusOptions: ['active', 'inactive'],
                dialogFormVisible: false,
                dialogStatus: '',
                textMap: {
                    update: 'Edit',
                    create: 'Create'
                },

                temp: {
                    id: undefined,
                    name: '',
                    email: '',
                    role_id: '',
                    password: '',
                    password_confirmation: '',
                    status: 'inactive',
                },
                rules: {
                    name: [{required: true, message: 'name is required', trigger: 'change'}],
                    email: [{type: 'email', required: true, message: 'email is required', trigger: 'blur'}],
                    password: [{required: true, message: 'password is required', trigger: 'blur'}],
                    password_confirmation: [
                        {
                            validator: confirmpassword,
                            trigger: 'blur'
                        }
                    ],
                    role_id: [{required: true, message: 'Role is required', trigger: 'blur'}],


                }


            }
        },
        filters: {
            statusFilter(status) {
                const statusMap = {
                    active: 'success',
                    inactive: 'gray',
                    true: 'success',
                    false: 'gray',
                }
                return statusMap[status]
            }
            ,
            verifiedFilter(status) {
                const statusMap = {
                    true: 'Verified',
                    false: 'Unverified',
                }
                return statusMap[status]
            }
        },
        created() {
            this.getList()
            this.$axios.get("/role").then(response => {
                this.roles = response.data.data;
            })
        },
        methods: {
            getList() {
                this.listLoading = true
                this.$axios.get("/user", {params: this.listQuery}).then(response => {
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
                    status: undefined,
                    name: undefined,
                    type: undefined,
                    sort: 'desc'
                };
                this.getList()
            },
            createData() {
                this.$refs['dataForm'].validate((valid) => {
                    if (valid) {
                        this.$axios.post("/user/", this.temp).then(response => {
                            this.list.unshift(response.data.data)
                            this.dialogFormVisible = false
                            this.$message({
                                type: 'success',
                                message: 'User Creation completed'
                            });
                        })
                    }
                })
            },
            updateData() {
                this.$refs['dataForm'].validate((valid) => {
                    if (valid) {
                        this.temp["_method"] = "put";
                        this.$axios.post("/user/" + this.temp.id, this.temp).then(response => {
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
                                message: 'User update completed'
                            });
                        })
                    }
                })
            },
            resetTemp() {
                this.temp = {
                    id: undefined,
                    name: '',
                    email: '',
                    role_id: '',
                    password: '',
                    password_confirmation: '',
                    status: 'inactive',


                }
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
                    this.$axios.delete("/user/" + row.id).then(response => {
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

            handleModifyStatus(row, status) {
                this.$message({
                    message: 'Success',
                    type: 'success'
                })
                row.status = status
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
                this.temp.active = this.temp.status === "active" ? "inactive" : "active"
                this.$axios.post("/user/" + this.temp.id, this.temp).then(response => {
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
                        message: 'User update completed'
                    });
                })
            },


        }
    }
</script>
