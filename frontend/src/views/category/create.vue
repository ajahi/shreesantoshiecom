<template>
 <category-detail></category-detail>
</template>
<script>
    import waves from '../../directive/waves/index.js'
    import CategoryDetail from './components/detail.vue'

    export default {
        directives: {
            waves
        },
        name: "createCategory",
        components : {CategoryDetail}
    }
</script>
