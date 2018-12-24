<template>
    <role-detail :is-edit="true"></role-detail>
</template>
<script>
    import waves from '../../directive/waves/index.js'
    import RoleDetail from './components/detail.vue'

    export default {
        directives: {
            waves
        },
        name: "editRole",
        components : {RoleDetail}
    }
</script>
