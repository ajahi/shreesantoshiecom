<template>
    <div  class="container" >
        <p class="form-control" style="font-size:25px;">{{modelvalue.title}}</p>
        <span class="well ">
        <el-input type="text" placeholder="answer" v-model="modelvalue.answer" aria-required="true"></el-input>
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
                value : ""

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