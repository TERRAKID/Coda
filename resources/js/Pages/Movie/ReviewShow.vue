<template>
    <app-layout>
        <div class="bg-cover bg-center text-white pb-2" :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(https://image.tmdb.org/t/p/w500' + movie.backdrop_path + ')'}">
            <inertia-link :href="'/user/' + review.user_id" class="p-5 pb-0 flex items-center text-3xl">
                <div class="bg-blue-primary rounded-full bg-cover bg-center p-10 inline-block mr-3" :style="{'background-image':'url(/storage/' + review.profile_photo_url + ')'}"></div>
                <div>
                    <div class="flex flex-wrap justify-between">
                        <p class="text-lg">{{ friendlyDate(review.created_at) }}</p>
                        <div v-if="review.rating < 5" class="flex">
                            <img class="w-6 ml-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                            <img class="w-6 ml-2" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                        </div>
                        <div v-else class="flex">
                            <img class="w-6 ml-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                        </div>
                    </div>
                    <h2>{{ review.name }}'s review of:</h2>
                </div>
            </inertia-link>
            
            <inertia-link :href="'/movie/' + movie.id" class="p-5 flex items-center">
                <div class="h-48 w-32 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
                <div class="ml-5">
                    <h3 class="text-2xl mb-4">
                        {{ movie.title }} ({{ movie.release_date.substring(0, 4) }})
                    </h3>
                    <div class="flex">
                        <p v-for="(genre, index) in movie.genres.slice(0,2)" :key="index" class="text-xl mr-3">{{ genre.name }}</p>
                    </div>
                </div>
            </inertia-link>
        </div>
        <div class="md:grid grid-cols-2 grid-rows-1">
            <div v-if="review.notes" class="p-5 col-start-2">
                <h3 class="border-b border-blue-primary mb-2 text-lg">Notes</h3>
                <p v-bind:key="line" v-for="line in (review.notes).split('\n')">{{line}}<br></p>
            </div>
            <div v-if="review.review" class="p-5 pt-0 md:pt-5 col-start-1 row-start-1">
                <h3 class="border-b border-blue-primary mb-2 text-lg">Review</h3>
                <p v-bind:key="line" v-for="line in (review.review).split('\n')">{{line}}<br></p>
            </div>
        </div>
        <div class="w-full text-center">
            <input v-on:click="confirmingUserDeletion = !confirmingUserDeletion" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="button" value="Delete">
        </div>
        <form @submit.prevent="onSubmit()" v-on:click="confirmingUserDeletion = !confirmingUserDeletion" v-show="confirmingUserDeletion" id="leave-community-form" class="min-w-screen h-screen animated fadeIn faster fixed left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-blue-primary bg-opacity-70">
            <div v-on:click="confirmingUserDeletion = !confirmingUserDeletion" class="bg-white rounded-2xl h-64 max-w-3/4 p-5 text-center flex flex-col justify-center items-center">
                <input type="hidden" name="_token" :value="csrf">
                <h3 class="text-2xl">Are you sure you want to delete this review?</h3>
                <input @click="submitForm" id="leave-confirm" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="submit" value="Delete">
                <input v-on:click="confirmingUserDeletion = !confirmingUserDeletion" id="leave-cancel" type="button" value="Cancel" class="bg-white underline cursor-pointer">
            </div>
        </form>
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
                confirmingUserDeletion: false,
                monthYearCheck: null,
                stars: null,
            };
        },
        props: {
            review: {
                type: Array,
                required: false,
            },
            movie: {
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
            onSubmit() {
                axios.post('/movie/' + this.movie.id + '/review/' + this.review.id + '/delete', {
                }).then((res) => {
                    if(res.status === 200){
                        window.location.href = "/diary"; //there should be a better way to do this
                        this.$router.push('/diary');
                    }
                    console.log('deleted');
                }).catch((err) => {
                    this.errors = [];
                })
            },
        },
    };
</script>
