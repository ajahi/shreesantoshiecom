<template>
    <div id="app">
        <topnav></topnav>
        <router-view></router-view>
    </div>
</template>

<script>
    import topnav from './views/partials/topNav.vue'

    export default {
        name: 'app',
        components: {
            topnav: topnav
        },
        data() {
            return {}
        },
        methods: {}
    }
</script>
