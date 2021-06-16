<template>
    <app-layout>
        <div v-if="movie == null">
            <div class="bg-green p-4 text-white text-xl">
                <h2>Add some movies to your collection to use this page</h2>
            </div>
            <div class="h-screen flex justify-center items-center" :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9))'}">
                <h3 class="text-white -mt-20">A random movie from your collection will appear here</h3>
            </div>
        </div>
        <div v-else class="fixed w-full">
            <div class="bg-green p-4 text-white text-xl">
                <h2>Get a random movie from your collection</h2>
            </div>
            <div class="h-screen w-full bg-cover bg-center flex flex-col items-center justify-center" :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)), url(https://image.tmdb.org/t/p/w1280' + movie.backdrop_path + ')'}">
                <inertia-link :href="'/movie/' + movie.id" class="-mt-20 -ml-64 mr-32 p-5 flex items-center justify-between text-white">
                    <div class="flex items-center">
                        <div class="pt-64 pl-48 pb-10 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
                        <div class="ml-5">
                            <h3 class="text-2xl mb-4">
                                {{ movie.title }} 
                                <span v-if="movie.release_date" class="text-2xl">({{ movie.release_date.substring(0, 4) }})</span>
                                <span v-else class="text-2xl">(tbd)</span>
                            </h3>
                            <p>{{ friendlyRuntime(movie.runtime) }}</p>
                            <div class="flex">
                                <p v-for="(genre, index) in movie.genres.slice(0,2)" :key="index" class="text-xl mr-3">{{ genre.name }}</p>
                            </div>
                        </div>
                    </div>
                </inertia-link>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import Welcome from "@/Jetstream/Welcome";

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        data(){
            return{
                loading: false,
            }
        },
        props: {
            movie: {
                type: Array,
                required: true,
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
            newMovie() {
                axios.get('/random', {
                }).then((res) => {
                    if(res.status === 200){
                        this.collectionStatus = false;
                    }
                }).catch((err) => {
                    this.errors = [];
                })
            },
        },
    }
</script>
