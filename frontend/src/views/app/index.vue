<template>
    <div class="app-container">
        <el-row :gutter="12">
            <el-col :span="8">
                <el-card shadow="always">
                    <router-link to="/app/slide">Slide</router-link>
                </el-card>
            </el-col>
            <el-col :span="8">
                <el-card shadow="always">
                    <router-link to="/app/menu">Menu</router-link>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script>

    import waves from '../../directive/waves/index.js'

    export default {
        directives: {
            waves
        },        data() {

            return {



            }
        },
        filters: {

        },
        created() {
        },
        methods: {




        }
    }
</script>
