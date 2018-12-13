<template>


    <el-row type="flex" v-show="this.$route.meta.nav=== false ? false : true" justify="center">
        <el-col :span="18">
            <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
                <el-menu-item index="1">
                    <router-link to="/" class="link">Home</router-link>
                </el-menu-item>

                <template v-for="first in menu">
                    <el-submenu v-if="first.children && first.children.length > 0" :index="first.id">
                        <template slot="title">
                            <router-link :to="'/category/'+first.title" class="link">{{ first.title }}</router-link>
                        </template>


                        <template v-for="second in first.children">

                            <el-submenu v-if="second.children && second.children.length > 0" :index="second.id+'1'">
                                <template slot="title">
                                    <router-link :to="'/category/'+second.title" class="link">{{ second.title }}
                                    </router-link>
                                </template>


                                <template v-for="third in second.children">

                                    <el-submenu v-if="third.children && third.children.length > 0"
                                                :index="third.id+'2'">
                                        <template slot="title">
                                            <router-link :to="'/category/'+third.title" class="link">{{ third.title
                                                }}
                                            </router-link>
                                        </template>

                                        <template v-for="fourth in third.children">

                                            <el-submenu v-if="fourth.children && fourth.children.length > 0"
                                                        :index="fourth.id+'3'">
                                                <template slot="title">
                                                    <router-link :to="'/category/'+fourth.title" class="link">{{
                                                        fourth.title
                                                        }}
                                                    </router-link>
                                                </template>

                                                <template v-for="fifth in fourth.children">

                                                    <el-submenu v-if="fifth.children && fifth.children.length > 0"
                                                                :index="fifth.id+'4'">
                                                        <template slot="title">
                                                            <router-link :to="'/category/'+fifth.title"
                                                                         class="link">{{
                                                                fifth.title }}
                                                            </router-link>
                                                        </template>
                                                        <template v-for="sixth in fifth.children">

                                                            <el-submenu
                                                                    v-if="sixth.children && sixth.children.length > 0"
                                                                    :index="sixth.id+'4'">
                                                                <template slot="title">
                                                                    <router-link :to="'/category/'+sixth.title"
                                                                                 class="link">
                                                                        {{ sixth.title }}
                                                                    </router-link>
                                                                </template>
                                                                <el-menu-item v-for="seven in sixth.children"
                                                                              :key="seven.id"      :index="seven.id + '-' + seven.id">
                                                                    {{seven.title }}
                                                                </el-menu-item>
                                                            </el-submenu>

                                                            <el-menu-item v-else :index="sixth.id">
                                                                <router-link :to="'/category/'+sixth.title"
                                                                             class="link">{{
                                                                    sixth.title }}
                                                                </router-link>
                                                            </el-menu-item>
                                                        </template>
                                                    </el-submenu>

                                                    <el-menu-item v-else :index="fifth.id">
                                                        <router-link :to="'/category/'+fifth.title" class="link">{{
                                                            fifth.title }}
                                                        </router-link>
                                                    </el-menu-item>
                                                </template>

                                            </el-submenu>

                                            <el-menu-item v-else :index="third.id + '-' + fourth.id">
                                                <router-link :to="'/category/'+fourth.title" class="link">{{
                                                    fourth.title }}
                                                </router-link>
                                            </el-menu-item>
                                        </template>


                                    </el-submenu>

                                    <el-menu-item v-else :index="second.id + '-' + third.id">
                                        <router-link :to="'/category/'+third.title" class="link">{{ third.title }}
                                        </router-link>
                                    </el-menu-item>
                                </template>


                            </el-submenu>

                            <el-menu-item v-else :index="first.id + '-' + second.id">
                                <router-link :to="'/category/'+second.title" class="link">{{second.title }}
                                </router-link>
                            </el-menu-item>
                        </template>


                    </el-submenu>
                    <el-menu-item v-else :index="first.id">
                        <router-link :to="'/category/'+first.title" class="link">{{ first.title }}</router-link>
                    </el-menu-item>
                </template>
                <el-menu-item index="4" v-if="this.$auth.isAuthenticated()" style="float: right"><a
                        @click="logout">Logout</a></el-menu-item>
                <el-menu-item index="5" v-if="!this.$auth.isAuthenticated()" style="float: right"><a
                        @click="login">Login</a></el-menu-item>
                <el-menu-item index="5" v-if="!this.$auth.isAuthenticated()" style="float: right"><a
                        @click="register">Register</a></el-menu-item>
            </el-menu>

        </el-col>
    </el-row>


</template>

<script>
    export default {

        data() {
            return {
                show: true,
                menu: null,
            }
        }
        ,
        created() {
            this.$axios.get("/menu").then(response => {
                console.log(response.data)
                this.menu = response.data.data;
            })
        },
        methods: {
            logout() {
                this.$auth.destroyToken();
                this.$router.push('/login')
            },
            login() {

                this.$router.push('/login')
            },
            register() {

                this.$router.push('/register')
            }
        }
    }
</script>

<style>

</style>