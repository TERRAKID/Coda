<template>
    <app-layout>
        <div class="bg-cover bg-center text-white pb-2 mb-5" :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url(https://image.tmdb.org/t/p/w1280' + movie[0].backdrop_path + ')'}">
            <div class="p-5 pt-32 text-3xl flex flex-wrap items-center justify-between">
                <div>
                    <h2>Recent reviews:</h2>
                    <p class="text-sm">Background from: <inertia-link class="underline ml-2" :href="'/movie/' + movie[0].id">{{ movie[0].title }}</inertia-link></p>
                </div>
                <inertia-link class="underline text-xl" href="/dashboard">Return to dashboard</inertia-link>
            </div>
        </div>
        <div v-if="reviews == null" class="p-5">
            <h3 class="text-3xl mb-5">There are no written reviews for {{ movie.title }} right now.</h3>
            <inertia-link :href="'/movie/' + movie.id" class="text-2xl underline">Return to the movie page</inertia-link>
        </div>
        <div v-else class="p-5 pt-0 max-w-4xl">
            <inertia-link v-for="(review, index) in reviews" :key="index" :href="'/movie/' + movie.id + '/review/' + review.id" class="block border-b border-blue-primary mb-5">
                <div class="flex items-center justify-between flex-wrap">
                    <inertia-link :href="'/user/' + review.user_id" class="flex items-center w-3/4 md:w-1/2">
                        <div class="p-8 rounded-full bg-center bg-cover bg-blue-primary" :style="{'background-image':'url('+ this.users[index].profile_photo_url + ')'}"></div>
                        <div class="ml-3">
                            <h3 class="flex flex-wrap mr-2">{{ users[index].name }}'s review of </h3><inertia-link class="underline" :href="'/movie/' + movie[index].id">{{ movie[index].title }}</inertia-link>
                            <p>{{ friendlyDate(review.created_at) }}</p>
                        </div>
                    </inertia-link>
                    <div v-if="review.rating < 5" class="flex m-5 mb-0 md:m-0">
                        <img class="w-6 md:w-10 mr-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                        <img class="w-6 md:w-10 mr-2" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                    </div>
                    <div v-else class="flex m-5 mb-0 md:m-0">
                        <img class="w-6 md:w-10 mr-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                    </div>
                </div>
                <div class="m-5">
                    <p v-bind:key="line" v-for="line in (review.review).split('\n')">{{line}}<br></p>
                </div>
            </inertia-link>
        </div>
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
            reviews: {
                type: Array,
                required: false,
            },
            movie: {
                type: Array,
                required: false,
            },
            users: {
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
            }
        },
    };
</script>
