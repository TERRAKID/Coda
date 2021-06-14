<template>
    <app-layout>
        <div v-if="collection == null" class="bg-green p-4 text-white text-xl">
            <h2>You can use this page to track the films you own or simply use it as a watchlist</h2>
        </div>

        <div v-else>
            <div class="bg-green p-4 text-white text-xl">
                <h2>Your film collection</h2>
            </div>
            <div class="h-screen flex flex-wrap bg-center bg-cover bg-fixed">
                <inertia-link class="m-10 mb-0 mr-0 text-center flex flex-col items-center inline-block" v-for="(movie, index) in collection" :key="index" :href="'/movie/' + movie.id">
                    <div class="pt-64 pl-48 pb-10 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
                    <div class="w-48 text-blacktext-center flex flex-col flex-wrap items-center">
                        <h2 class="text-lg m-2">{{ movie.title }}</h2>
                        <div>
                            <h3 class="text-lg"> Directed by:</h3>
                            <div class="flex flex-col">
                                <p class="ml-1" v-for="(director, directorIndex) in directors[index]" :key="directorIndex">
                                    {{ director.name }}
                                </p>
                            </div>
                        </div>
                    </div>
                </inertia-link>
            </div>
        </div>

        <inertia-link href="/movie/search" class="mb-10 md:mb-0 w-20 flex items-center fixed right-5 md:right-10 bottom-10">
            <img src="/img/create.svg" alt="Log a movie">
        </inertia-link>
    </app-layout>
</template>

<script type="text/javascript">
    import AppLayout from "@/Layouts/AppLayout";
    import { reactive } from "vue";

    export default {
        components: {
            AppLayout,
        },
        data() {
            return {
                monthYearCheck: null,
                stars: null,
            };
        },
        props: {
            collection: {
                type: Array,
                required: false,
            },
            directors: {
                type: Array,
                required: false,
            },
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {
            removeFromCollection() {
                axios.post('/collection/' + this.movie.id + '/remove', {
                }).then((res) => {
                    if(res.status === 200){
                        this.collectionStatus = true;
                    }
                }).catch((err) => {
                    this.errors = [];
                })
            },
        },
    };
</script>
