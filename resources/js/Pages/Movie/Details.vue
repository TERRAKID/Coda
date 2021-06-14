<template>
    <app-layout>
        <div class="bg-cover bg-center text-white pb-2" :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(https://image.tmdb.org/t/p/w1280' + movie.backdrop_path + ')'}">
            <div class="p-5 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="h-24 w-16 md:h-64 md:w-48 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
                    <div class="ml-5">
                        <h3 class="text-2xl mb-4">
                            {{ movie.title }} 
                            <span v-if="movie.release_date" class="text-2xl">({{ movie.release_date.substring(0, 4) }})</span>
                            <span v-else class="text-2xl">(tbd)</span>
                        </h3>
                        <div class="flex">
                            <p v-for="(genre, index) in movie.genres.slice(0,2)" :key="index" class="text-xl mr-3">{{ genre.name }}</p>
                        </div>
                    </div>
                </div>
                <div class="text-xl text-right">
                    <p>{{ friendlyRuntime(movie.runtime) }}</p>
                </div>
            </div>
            <div class="m-5 mt-0 text-lg">
                <a v-if="trailer != null" class="underline" target="_blank" :href="'https://www.youtube.com/watch?v=' + trailer">Watch the trailer</a>
                <div class="flex items-center justify-between mt-5 w-full">
                    <div>
                        <h3>Global Rating:</h3>
                        <inertia-link v-if="globalReviews != null" :href="'/movie/' + movie.id + '/reviews'" class="underline">Read reviews</inertia-link>
                    </div>
                    <div v-if="globalReviews == null" class="ml-5 w-64 text-right">
                        <h4>There are no reviews yet for this movie.</h4>
                    </div>
                    <div v-else class="ml-5">
                        <div v-if="globalReviews < 5" class="flex">
                            <img class="w-8 m-2 ml-0" v-for="index in globalReviews" :key="index" src="/img/star.svg" alt="Full Star">
                            <img class="w-8 m-2 ml-0" v-for="index in 5-globalReviews" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                        </div>
                        <div v-else class="flex">
                            <img class="w-8 m-2 ml-0" v-for="index in globalReviews" :key="index" src="/img/star.svg" alt="Full Star">
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-5 w-full">
                    <div>
                        <h3>Friends Rating:</h3>
                        <inertia-link v-if="friendReviews != null" :href="'/movie/' + movie.id + '/reviews/friends'" class="underline">Read reviews</inertia-link>
                    </div>
                    <div v-if="friendReviews == null" class="ml-5 w-64 text-right">
                        <h4>None of your friends have reviewed this movie yet.</h4>
                    </div>
                    <div v-else class="ml-5">
                        <div v-if="friendReviews < 5" class="flex">
                            <img class="w-8 m-2 ml-0" v-for="index in friendReviews" :key="index" src="/img/star.svg" alt="Full Star">
                            <img class="w-8 m-2 ml-0" v-for="index in 5-friendReviews" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                        </div>
                        <div v-else class="flex">
                            <img class="w-8 m-2 ml-0" v-for="index in friendReviews" :key="index" src="/img/star.svg" alt="Full Star">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="p-5">
            <h3 class="text-xl">Directed by: 
                <span v-for="(director, index) in directors" :key="index">
                    <span v-if="index > 0">, </span>
                    {{ director.name }}
                </span>
            </h3>
            <h3 class="mt-2 text-xl">Synopsis:</h3>
            <p>{{ movie.overview }}</p>
        </div>
        <div class="p-5">
            <h3 class="text-xl">Cast:</h3>
            <div class="flex flex-wrap content-center text-center justify-around mt-2 md:justify-start">
                <article class="w-24 m-2" v-for="(castMember, index) in cast.slice(0, 6)" :key="index">
                    <div class="h-20 w-20 rounded-full bg-center bg-cover inline-block" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + castMember.profile_path + ')'}"></div>
                    <h3 class="">{{ castMember.name }}</h3>
                </article>
            </div>
        </div>
        
        <inertia-link :href="'/diary/' + movie.id + '/create'" class="mb-10 md:mb-0 w-20 flex items-center text-center text-white text-6xl rounded-full bg-green fixed right-5 md:right-10 bottom-10">
            <img src="/img/create.svg" alt="Log a movie">
        </inertia-link>

        <div class="w-full text-center">
            <form  @submit.prevent="addToCollection()">
                <input v-on:click="addingToCollection = !addingToCollection" v-show="!addingToCollection" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="submit" value="Add to collection">
            </form>
        </div>

        <div class="w-full text-center">
            <form  @submit.prevent="removeFromCollection()">
                <input v-on:click="addingToCollection = !addingToCollection" v-show="addingToCollection" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="submit" value="Remove from collection">
            </form>
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
                addingToCollection: this.collectionStatus,
            };
        },
        props: {
            globalReviews: {
                type: Array,
                required: false,
            },
            friendReviews: {
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
            trailer: {
                type: String,
                required: false,
            },
            directors: {
                type: Array,
                required: false,
            },
            collectionStatus: {
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
            },
            addToCollection() {
                axios.post('/collection/' + this.movie.id + '/add', {
                }).then((res) => {
                    if(res.status === 200){
                        this.collectionStatus = false;
                    }
                }).catch((err) => {
                    this.errors = [];
                })
            },
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
