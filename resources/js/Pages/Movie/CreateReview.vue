<template>
    <app-layout>
        <inertia-link :href="'/movie/' + movie.id" class="m-5 flex items-center">
            <div class="h-24 w-16 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
            <div class="ml-5">
                <h3 class="text-2xl mb-4">
                    {{ movie.title }} ({{ movie.release_date.substring(0, 4) }})
                </h3>
                <div class="flex">
                    <p v-for="(genre, index) in movie.genres.slice(0, 3)" :key="index" class="text-xl mr-3">{{ genre.name }}</p>
                </div>
            </div>
        </inertia-link>
        <form @submit.prevent="onSubmit()" class="mb-40 md:mb-0 md:grid grid-cols-2 gap-4">
            <input type="hidden" name="_token" :value="csrf">
            <div>
                <p v-if="this.errors.length" class="m-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">{{ this.errors['0'] }}</p>
                <div v-if="this.success.length" class="m-5 bg-successGreen text-successGreenBorder border border-successGreenBorder text-green-700 px-4 py-3 rounded">
                    <p role="alert">Your review was submitted successfully</p>
                    <p class="mt-1"><inertia-link class="underline" href="/diary">Return to diary</inertia-link> or <inertia-link class="underline" href="/movie/search" >Create another review</inertia-link></p>
                </div>

                <label for="view_date" class="p-5 bg-blue-primary block flex items-center justify-between text-black text-2xl mb-3">
                    <h3 class="text-white mr-5">View date:</h3>
                    <input class="" type="date" name="view_date" id="view_date" v-model="view_date">
                </label>

                <div class="p-5 bg-blue-primary block flex items-center justify-between text-white text-2xl mb-3">
                    <h3>Rating:</h3>
                    <!-- 
                    <label class="ml-3" v-for="index in 5" :key="index">
                        <input class="hidden" type="radio" name="rating" :id="'rating-' + index" :value="index" v-model="form.rating">
                        <img @click="starHover" class="w-10 ml-0" src="/img/star-outline.svg" alt="">
                        <img v-show="!starVis" class="w-10 ml-0" src="/img/star.svg" alt="">
                    </label>
                    -->
                    <label class="text-black ml-5" for="rating">
                        <select class="text-black" name="rating" id="rating" v-model="rating">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="h-full">
                <label for="review" class="block text-white text-2xl">
                    <div class="p-6 bg-blue-primary">
                        Review
                    </div>
                    <textarea class="w-full h-40 text-black p-5 pt-2 -mb-2 h-full" placeholder="Write a review..." name="review" id="review" cols="30" rows="10" v-model="review"></textarea>
                </label>
                
                <label for="notes" class="block text-white text-2xl">
                    <div class="p-5 bg-blue-primary">
                        Notes
                    </div>
                    <textarea class="w-full h-40 text-black p-5 pt-2" placeholder="Use this field to write down some notes such as where you saw the film, who with, film stock, etc.&#10;&#10;Only you will be able to see this" name="notes" id="notes" cols="30" rows="10" v-model="notes"></textarea>
                </label>
            </div>

            <!--
            <div class="block text-white text-2xl mb-3 row-start-1 col-start-1">
                <div class="p-5 bg-blue-primary">
                    Share to
                </div>
                <label v-for="(community, index) in communities" :key="index" class="flex items-center grid grid-cols-4 text-black m-5 mt-4 mb-0" :for="'community-' + index">
                    <p class="col-span-3 text-xl">{{ community.name }}</p>
                    <input class="justify-self-end" type="checkbox" :value="community.id" :id="'community-' + index" :name="'community-' + index">
                </label>
            </div>
            -->
            <div class="w-full fixed bottom-16 duration-200 bg-green hover:bg-greenDark md:bg-transparent md:hover:bg-transparent md:bottom-0 md:relative text-center col-span-2">
                <input @click="submitForm" class="cursor-pointer transition-all duration-200 bg-transparent md:bg-green md:hover:bg-greenDark text-white p-3 pl-16 pr-16 text-2xl rounded-full" type="submit" value="Confirm">
            </div>
        </form>
    </app-layout>
</template>

<script type="text/javascript">
    import AppLayout from "@/Layouts/AppLayout";
    import { reactive } from "vue";
    import { Inertia } from '@inertiajs/inertia';
    import axios from 'axios';

    export default {
        components: {
            AppLayout,
        },
        data() {
            return {
                starVis: true,
                errors: [],
                success: [],
                view_date: '',
                rating: '',
                review: '',
                notes: '',
                csrf: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            };
        },
        props: {
            movie: {
                type: Array,
                required: false,
            },
            communities: {
                types: Array,
                required: false,
            },
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {
            starHover(){
                console.log(this.rating);
                this.starVis = !this.starVis;
            },
            onSubmit() {
                axios.post('/diary/' + this.movie.id + '/create', {
                    view_date: this.view_date,
                    rating: this.rating,
                    review: this.review,
                    notes: this.notes,
                }).then((res) => {
                    console.log(res.status);
                    if(res.status === 200){
                        this.success.push('Created review successfully');
                        window.scrollTo({top: 0, behavior: 'smooth'});
                        this.errors = [];
                    }
                }).catch((err) => {
                    this.errors = [];
                    if(!this.view_date.length){
                        this.errors.push('Please enter a date');
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    }
                    if(!this.rating.length){
                        this.errors.push('Please enter a rating');
                        window.scrollTo({top: 0, behavior: 'smooth'});
                    }
                })
            },
        },
    };
</script>
