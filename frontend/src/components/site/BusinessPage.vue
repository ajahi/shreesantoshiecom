<template>
    <v-container fluid>


        <v-layout>
            <v-flex >
                <v-card>
                    <v-container fluid grid-list-md>
                        <v-layout row wrap>
                            <v-flex
                                    xs12
                                    md6
                                    lg3
                                    v-for="n in 12"
                                    :key="n"
                            >
                                <v-card flat tile>
                                    <v-card-media
                                            :src="`https://api.adorable.io/avatars/285/abott@adorable.png`"
                                            height="400px"
                                    >
                                    </v-card-media>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>


    </v-container>
</template>
<script>
    export default {
        created: function () {
            this.$store.commit('setLayout', 'simple-layout');
        }
    }
</script>