<template>
    <app-layout>
        <div v-if="reviews == null" class="bg-green p-4 text-white text-xl">
            <h2>Log a movie by clicking the button in the bottom right</h2>
        </div>
        <div v-else class="mb-24">
            <div class="bg-green p-4 text-white text-xl">
                <h2>Your logged movies</h2>
            </div>
            <div v-for="(monthYear, index) in reviews" :key="index">
                    <div class="bg-purple text-white text-2xl p-8 pt-2 pb-2">
                        <h2>{{ this.monthYear(index) }}</h2>
                    </div>
                <inertia-link v-for="(review, index) in monthYear" :key="index" :href="'/movie/' + movie[index].id + '/review/' + review.id">
                    <div class="flex justify-between mt-5 mb-5">
                        <div class="flex">
                            <div class="flex items-center">
                                <div class="h-20 w-12 text-3xl flex items-center justify-center text-white p-3 ml-5 mr-5 bg-green">
                                    <p>{{ getDay(review.view_date) }}</p>
                                </div>
                                <inertia-link :href="'/movie/' + movie[index].id">
                                    <div class="h-20 w-12 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie[index].poster_path + ')'}"></div>
                                </inertia-link>
                            </div>
                            <div class="ml-5 flex flex-col justify-center">
                                <inertia-link :href="'/movie/' + movie[index].id">
                                    <h3 class="text-2xl">{{ movie[index].title }}</h3>
                                </inertia-link>
                                <div v-if="review.rating">
                                    <div v-if="review.rating < 5" class="flex">
                                        <img class="w-6 sm:w-10 mr-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                                        <img class="w-6 sm:w-10 mr-2" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                                    </div>
                                    <div v-else class="flex">
                                        <img class="w-6 sm:w-10 mr-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <inertia-link :href="'/movie/' + movie[index].id + '/review/' + review.id" v-if="review.review" class="flex items-center p-5 pr-10 md:pr-20">
                            <img class="w-5" src="/img/arrow-short.svg" alt="">
                        </inertia-link>
                    </div>
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

                var dateArray = str.substring(0, 7).split("-");
                dateArray.reverse();
                
                return months[dateArray[0] - 1] + ' ' + dateArray[1];
            },
            setCheck(str){
                this.monthYearCheck = str;
                
            }
        },
    };
</script>
