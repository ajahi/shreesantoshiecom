<template>
<div>

    <div class="slider">
        <el-row>
            <el-col :span="24">
                <el-carousel :interval="5000" arrow="always" height="">
                    <el-carousel-item v-for="item in slide" :key="item.id">
                        <img :src="item.image"/>
                        <div class="caption">
                            <h1 style="font-size: 2.5rem;">{{item.title}}</h1>
                        </div>
                    </el-carousel-item>
                </el-carousel>
            </el-col>
        </el-row>
    </div>

</div>

</template>

<script>

    export default {

        components: {},
        data() {
            return {
                slide:null,
                arrivalQuery: {
                    limit:4,
                    sort: 'desc'
                },


            }
        }
    ,
    created() {

        this.$axios.get("/slide", {params: this.arrivalQuery}).then(response => {
            this.slide = response.data.data;
        })
    },
        mounted() {

        },
        methods: {


        },
        filters: {

        }
    }

</script>
<style>

</style>