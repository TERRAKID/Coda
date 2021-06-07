<template>
    <app-layout>
        <div v-for="(review, index) in reviews" :key="index">
            <div v-if="monthYear(review.created_at) !=  monthYearCheck" class="bg-purple text-white text-2xl p-8 pt-2 pb-2">
                <h2>{{ monthYear(review.created_at) }}</h2>
                {{ setCheck(monthYear(review.created_at)) }}
            </div>
            <div class="flex space-between mt-5 mb-5">
                <div class="flex">
                    <div class="flex items-center">
                        <div class="text-3xl flex items-center justify-center text-white p-3 ml-5 mr-5 h-24 w-16 bg-green">
                            <p>{{ getDay(review.created_at) }}</p>
                        </div>
                        <div class="h-24 w-16 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie[index].poster_path + ')'}"></div>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-3xl">{{ movie[index].title }}</h3>
                        <div v-if="review.rating < 5" class="flex">
                            <img class="w-10 m-2 ml-0" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                            <img class="w-10 m-2 ml-0" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                        </div>
                        <div v-else class="flex">
                            <img class="w-10 m-2 ml-0" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <inertia-link class="mb-10 w-20 flex items-center text-center text-white text-6xl rounded-full bg-green fixed right-5 bottom-10">
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
