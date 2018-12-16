<template>
 <user-detail ></user-detail>
</template>
<script>
    import waves from '../../directive/waves/index.js'
    import UserDetail from './components/detail.vue'

    export default {
        directives: {
            waves
        },
        name: "editRole",
        components : {UserDetail}
    }
</script>
