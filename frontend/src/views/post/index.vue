<template>
    <div class="app-container">

        <!--Different option for page -->
        <div class="filter-container">
            <!--name filter-->
            <el-input
                    v-model="listQuery.name"
                    style="width: 200px;"
                    class="filter-item"
                    placeholder="keyword"
                    @keyup.enter.native="handleFilter"/>

            <!--sort filter-->
            <el-select v-model="listQuery.sort" style="width: 140px" class="filter-item" @change="handleFilter">
                <el-option v-for="item in sortOptions" :key="item.key" :label="item.label" :value="item.key"/>
            </el-select>

            <!--status filter-->
            <el-select @change='handleFilter' style="width: 140px" class="filter-item"  v-model="listQuery.status">
                <el-option v-for="item in statusOptions" :key="item.key" :label="item.label" :value="item.key">
                </el-option>
            </el-select>

            <!--call filter function-->
            <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">Search
            </el-button>

            <!--route to role create page-->
            <router-link to="/post/create">
                <el-button
                        class="filter-item"
                        style="margin-left: 10px;"
                        type="primary"
                        icon="el-icon-edit"
                >Create
                </el-button>
            </router-link>

            <!--Reset all filter and call api-->
            <el-button
                    class="filter-item"
                    style="margin-left: 10px;"
                    type="info"
                    @click="reload"
            >Reload
            </el-button>
        </div>

        <!--Table listing-->

        <el-table
                v-loading.body="listLoading"
                :data="list"
                element-loading-text="Loading"
                border
                fit
                highlight-current-row
                style="width: 100%;margin-top: 10px;margin-bottom: 10px">
            <el-table-column align="center" label="ID" width="95">
                <template slot-scope="scope">
                    {{ scope.$index +1 }}
                </template>
            </el-table-column>
            <el-table-column label="Title">
                <template slot-scope="scope">
                    {{ scope.row.title }}
                </template>
            </el-table-column>
            <el-table-column label="Description" align="center">
                <template slot-scope="scope">
                    <span>{{ scope.row.description.substring(0, 100) + '...' }}</span>
                </template>
            </el-table-column>

            <el-table-column label="Status" align="center" width="100">
                <template slot-scope="scope">
                    <span>{{scope.row.status | statusFilter}}</span>
                </template>
            </el-table-column>


            <el-table-column label="Category" align="center" width="100">
                <template slot-scope="scope">
                    {{scope.row.category.title}}
                </template>
            </el-table-column>


            <el-table-column align="center" label="Action" width="250" class-name="small-padding fixed-width">
                <template slot-scope="scope">

                    <router-link :to="'/post/edit/'+scope.row.id">
                        <el-button type="primary" size="mini">Edit</el-button>
                    </router-link>
                    <el-button
                            size="mini"
                            type="danger"
                            @click="handleDelete(scope.row)">Delete
                    </el-button>
                </template>
            </el-table-column>

        </el-table>

        <div class="pagination-container">
            <el-pagination
                    :current-page="listQuery.page"
                    :page-sizes="[50,100,150, 200]"
                    :page-size="listQuery.limit"
                    :total="total"
                    background
                    layout="total, sizes, prev, pager, next, jumper"
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"/>
        </div>


    </div>
</template>

<script>

    import waves from '../../directive/waves/index.js'

    export default {
        directives: {
            waves
        },
        filters: {
            statusFilter(status) {
                const statusMap = {
                    published: 'Published',
                    draft: 'Draft',

                }
                return statusMap[status]
            }
        },
        data() {

            return {

                total: null,
                list: null,
                listLoading: true,
                listQuery: {
                    page: 1,
                    limit: 50,
                    status: undefined,
                    name: undefined,
                    type: undefined,
                    sort: 'desc'
                },
                statusOptions: [{label: 'Published' ,key:'published'}, {label: 'Draft',key:'draft'}],
                sortOptions: [{label: 'Ascending', key: 'asc'}, {label: 'Descending', key: 'desc'}],


            }
        },
        created() {
            this.getList()

        },
        methods: {
            getList() {
                this.listLoading = true
                this.$axios.get('/post', {params: this.listQuery}).then(response => {
                    this.list = response.data.data
                    this.total = response.data.meta.total

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
                }
                this.getList()
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
                    this.$axios.delete('/post/' + row.id).then(response => {
                        const index = this.list.indexOf(row)
                        this.list.splice(index, 1)
                        this.$message({
                            type: 'success',
                            message: 'Delete completed'
                        })
                    })
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    })
                })
            },
            handleSizeChange(val) {
                this.listQuery.limit = val
                this.getList()
            },
            handleCurrentChange(val) {
                this.listQuery.page = val
                this.getList()
            },


        }
    }
</script>
