<template>
    <app-layout>
        <div class="m-5 flex items-center">
            <div class="h-24 w-16 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
            <div class="ml-5">
                <h3 class="text-2xl mb-4">
                    {{ movie.title }} ({{ movie.release_date.substring(0, 4) }})
                </h3>
                <div class="flex">
                    <p v-for="(genre, index) in movie.genres" :key="index" class="text-xl mr-3">{{ genre.name }}</p>
                </div>
            </div>
        </div>
        <form @submit.prevent="onSubmit()" class="mb-40">
            <input type="hidden" name="_token" :value="csrf">
            <label for="view_date" class="p-5 bg-blue-primary block flex items-center text-black text-2xl mb-3">
                <input type="date" name="view_date" id="view_date" v-model="view_date">
            </label>

            <div class="p-5 bg-blue-primary block flex items-center text-white text-2xl mb-3">
                Rating:
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

            <label for="review" class="block text-white text-2xl mb-3">
                <div class="p-5 bg-blue-primary">
                    Review
                </div>
                <textarea class="w-full h-40 text-black p-5 pt-2" placeholder="Write a review..." name="review" id="review" cols="30" rows="10" v-model="review"></textarea>
            </label>
            
            <label for="notes" class="block text-white text-2xl mb-3">
                <div class="p-5 bg-blue-primary">
                    Notes
                </div>
                <textarea class="w-full h-40 text-black p-5 pt-2" placeholder="Use this field to write down some notes such as where you saw the film, who with, film stock, etc.&#10;&#10;Only you will be able to see this" name="notes" id="notes" cols="30" rows="10" v-model="notes"></textarea>
            </label>

            <div class="block text-white text-2xl mb-3">
                <div class="p-5 bg-blue-primary">
                    Share to
                </div>
                <label v-for="(community, index) in communities" :key="index" class="flex items-center grid grid-cols-4 text-black m-5 mt-4 mb-0" :for="'community-' + index">
                    <p class="col-span-3 text-xl">{{ community.name }}</p>
                    <input class="justify-self-end" type="checkbox" :value="community.id" :id="'community-' + index" :name="'community-' + index">
                </label>
            </div>
            <input @click="submitForm" class="cursor-pointer w-full text-center fixed md:inline-block bottom-16 md:bottom-0 bg-green p-5 text-3xl text-white" type="submit" value="Confirm">
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


                const formData = new FormData()
                formData.append('view_date', this.view_date)
                formData.append('rating', this.rating)
                formData.append('review', this.review)
                formData.append('notes', this.notes)
                axios.post('/diary/' + this.movie.id + '/create', {
                    view_date: this.view_date,
                    rating: this.rating,
                    review: this.review,
                    notes: this.notes,
                }).then((res) => {
                    console.log(res)
                })
            },
        },
    };
</script>
