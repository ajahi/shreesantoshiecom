<template>
    <div  class="container" >
        <p class="form-control" style="font-size:25px;">{{modelvalue.title}}</p>
        <span class="well ">
        <div v-for="(option , index) in modelvalue.option ">
            <el-radio class="btn btn-defult btn-md" v-model="answer"  :label=option.id border>{{option.title}} </el-radio>
        </div>
        </span>

    </div>
</template>

<script>


    export default {
        components: {
        },
        props: {
            object: {
                type: [Object],
                required: true,
            }


        },
        data() {
            return {
                modelvalue: this.object,
                answer : null

            }
        },
        watch: {
            answer: function (val) {
                this.modelvalue.answer = val;
            }
        },
        computed: {

        },
        created() {



        },
        methods: {

        }
    }
</script>