<template>
    <app-layout>
        <div class="h-screen bg-cover bg-center text-white" :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(https://image.tmdb.org/t/p/w500' + movie.backdrop_path + ')'}">
        <div class="p-5 flex items-center">
            <div class="h-24 w-16 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
            <div class="ml-5">
                <h3 class="text-2xl mb-4">
                    {{ movie.title }} ({{ movie.release_date.substring(0, 4) }})
                </h3>
                <div class="flex">
                    <p v-for="(genre, index) in movie.genres" :key="index" class="text-xl mr-3">{{ genre.name }}</p>
                </div>
            </div>
            <div class="text-xl">
                <p>{{ friendlyRuntime(movie.runtime) }}</p>
            </div>
        </div>
        <div class="m-5 mt-0 text-lg">
            <a class="underline" href="">Watch the trailer</a>
            <div class="flex items-center mt-5">
                <div>
                    <h3>Global Rating:</h3>
                    <inertia-link class="underline">Read reviews</inertia-link>
                </div>
                <div class="ml-5">
                    <div v-if="globalReviews < 5" class="flex">
                        <img class="w-8 m-2 ml-0" v-for="index in globalReviews" :key="index" src="/img/star.svg" alt="Full Star">
                        <img class="w-8 m-2 ml-0" v-for="index in 5-globalReviews" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                    </div>
                    <div v-else class="flex">
                        <img class="w-8 m-2 ml-0" v-for="index in globalReviews" :key="index" src="/img/star.svg" alt="Full Star">
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div>
                    <h3>Friends Rating:</h3>
                    <inertia-link class="underline">Read reviews</inertia-link>
                </div>
            </div>
            <div class="mt-5">
                <h3 class="text-xl">Directed by: 
                    <span v-for="(director, index) in directors" :key="index">
                        <span v-if="index > 0">, </span>
                        {{ director.name }}
                    </span>
                </h3>
                <p class="mt-2">{{ movie.overview }}</p>
            </div>
            <div class="mt-5">
                <h3>Cast</h3>
                <div class="flex flex-wrap content-center text-center mt-2">
                    <article class="w-24 m-2" v-for="(castMember, index) in cast.slice(0, 5)" :key="index">
                        <div class="h-20 w-20 rounded-full bg-center bg-cover inline-block" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + castMember.profile_path + ')'}"></div>
                        <h3 class="">{{ castMember.name }}</h3>
                    </article>
                </div>
            </div>
        </div>
        </div>
    </app-layout>
</template>

<script type="text/javascript">
    import AppLayout from "@/Layouts/AppLayout";
    import { reactive } from "vue";
    import { Inertia } from '@inertiajs/inertia';

    export default {
        components: {
            AppLayout,
        },
        data() {
            return {
                starVis: true,
            };
        },
        props: {
            globalReviews: {
                type: Array,
                required: false,
            },
            movie: {
                type: Array,
                required: false,
            },
            cast: {
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
            friendlyDate(str){
                var dateArray = str.substring(0, 10).split("-");
                dateArray.reverse();
                var date = (dateArray[0] + "/" + dateArray[1] + "/" + dateArray[2]);
                return date;
            },
            friendlyRuntime(str){
                var hours = Math.floor(str / 60);  
                var minutes = str % 60;
                return hours + "h " + minutes + "m";  
            }
        },
    };
</script>
