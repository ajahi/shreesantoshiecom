<template>
 <post-detail ></post-detail>
</template>
<script>
    import waves from '../../directive/waves/index.js'
    import PostDetail from './components/detail.vue'

    export default {
        directives: {
            waves
        },
        name: "editPost",
        components : {PostDetail}
    }
</script>
