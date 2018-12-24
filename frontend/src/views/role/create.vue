<template>
 <role-detail></role-detail>
</template>
<script>
    import waves from '../../directive/waves/index.js'
    import RoleDetail from './components/detail.vue'

    export default {
        directives: {
            waves
        },
        name: "createRole",
        components : {RoleDetail}
    }
</script>
