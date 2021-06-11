<template>
    <app-layout>
        <div v-for="(review, index) in reviews" :key="index">
            <div v-if="monthYear(review.view_date) !=  monthYearCheck" class="bg-purple text-white text-2xl p-8 pt-2 pb-2">
                <h2>{{ monthYear(review.view_date) }}</h2>
                {{ setCheck(monthYear(review.view_date)) }}
            </div>
            <div class="flex justify-between mt-5 mb-5">
                <div class="flex">
                    <div class="flex items-center">
                        <div class="text-3xl flex items-center justify-center text-white p-3 ml-5 mr-5 h-24 w-16 bg-green">
                            <p>{{ getDay(review.view_date) }}</p>
                        </div>
                        <inertia-link :href="'/movie/' + movie[index].id">
                            <div class="h-24 w-16 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie[index].poster_path + ')'}"></div>
                        </inertia-link>
                    </div>
                    <div class="ml-5">
                        <inertia-link :href="'/movie/' + movie[index].id">
                            <h3 class="text-3xl">{{ movie[index].title }}</h3>
                        </inertia-link>
                        <div v-if="review.rating < 5" class="flex">
                            <img class="w-10 m-2 ml-0" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                            <img class="w-10 m-2 ml-0" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                        </div>
                        <div v-else class="flex">
                            <img class="w-10 m-2 ml-0" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                        </div>
                    </div>
                </div>
                <inertia-link :href="'/movie/' + movie[index].id + '/review/' + review.id" v-if="review.review" class="flex items-center p-5 pr-10 md:pr-20">
                    <img class="w-5" src="/img/arrow-short.svg" alt="">
                </inertia-link>
            </div>
        </div>
        <inertia-link href="/movie/search" class="mb-10 md:mb-0 w-20 flex items-center text-center text-white text-6xl rounded-full bg-green fixed right-5 md:right-10 bottom-10">
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
            getDay(str){
                var dateArray = str.substring(0, 10).split("-");
                dateArray.reverse();
                var date = (dateArray[0]);
                return date;
            },
            monthYear(str){
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                var dateArray = str.substring(0, 10).split("-");
                dateArray.reverse();
                
                return months[dateArray[1] - 1] + ' ' + dateArray[2];
            },
            setCheck(str){
                this.monthYearCheck = str;
            }
        },
    };
</script>
