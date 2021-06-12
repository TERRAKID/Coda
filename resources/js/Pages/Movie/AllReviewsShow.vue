<template>
    <app-layout>
        <div class="p-5 flex items-center justify-between">
            <inertia-link :href="'/movie/' + movie.id" class="flex items-center">
                <div class="h-24 w-16 md:h-64 md:w-48 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
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
        <div v-if="reviews == null" class="p-5">
            <h3 class="text-3xl mb-5">There are no written reviews for {{ movie.title }} right now.</h3>
            <inertia-link :href="'/movie/' + movie.id" class="text-2xl underline">Return to the movie page</inertia-link>
        </div>
        <div v-else class="p-5 pt-0 max-w-4xl">
            <inertia-link v-for="(review, index) in reviews" :key="index" :href="'/movie/' + movie.id + '/review/' + review.id" class="block border-b border-blue-primary mb-5">
                <div class="flex items-center justify-between">
                    <inertia-link :href="'/user/' + review.user_id" class="flex items-center">
                        <div class="h-16 w-16 rounded-full bg-center bg-cover bg-blue-primary" :style="{'background-image':'url(/storage/' + review.profile_photo_path + ')'}"></div>
                        <div class="ml-3">
                            <h3>{{ review.name }}</h3>
                            <p>{{ friendlyDate(review.created_at) }}</p>
                        </div>
                    </inertia-link>
                    <div v-if="review.rating < 5" class="flex">
                        <img class="w-8 ml-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                        <img class="w-8 ml-2" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                    </div>
                    <div v-else class="flex">
                        <img class="w-8 ml-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
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
