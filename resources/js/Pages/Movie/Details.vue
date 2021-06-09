<template>
    <app-layout>
        <div class="h-screen bg-cover text-white" :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(https://image.tmdb.org/t/p/w500' + movie.backdrop_path + ')'}">
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
        <a href="">Watch the trailer</a>
        <div>
            <div>
                <h3>Rating:</h3>
                <inertia-link>Read reviews</inertia-link>
            </div>
            <!--
            <div class="ml-5">
                <div v-if="review.rating < 5" class="flex">
                    <img class="w-10 m-2 ml-0" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                    <img class="w-10 m-2 ml-0" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                </div>
                <div v-else class="flex">
                    <img class="w-10 m-2 ml-0" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                </div>
            </div>
            -->
        </div>
        <div>
            <div>
                <h3>Rating:</h3>
                <inertia-link>Read reviews</inertia-link>
            </div>
        </div>
        <div>
            <h3>Directed by: 
                <span v-for="(director, index) in directors" :key="index">
                    <span v-if="index > 0">, </span>
                    {{ director.name }}
                </span>
            </h3>
            <p>{{ movie.overview }}</p>
        </div>
        <div>
            <h3>Cast</h3>
            <div class="flex space-between">
                <article v-for="(castMember, index) in cast.slice(0, 5)" :key="index">
                    <div class="h-20 w-20 rounded-full bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + castMember.profile_path + ')'}"></div>
                    <h3>{{ castMember.name }}</h3>
                </article>
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
            reviews: {
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
