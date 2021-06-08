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
        <form @submit.prevent = "submit" class="mb-40">
            <label for="view_date" class="p-5 bg-blue-primary block flex items-center text-black text-2xl mb-3">
                <input type="date" name="view_date" id="view_date" v-model="form.view_date">
            </label>

            <div class="p-5 bg-blue-primary block flex items-center text-white text-2xl mb-3">
                Rating: 
                <label class="ml-3" v-for="index in 5" :key="index">
                    <input class="hidden" type="radio" name="rating" :id="'rating-' + index" :value="index" v-model="rating">
                    <img @click="starHover" class="w-10 ml-0" src="/img/star-outline.svg" alt="">
                    <!-- <img v-show="!starVis" class="w-10 ml-0" src="/img/star.svg" alt=""> -->
                </label>
            </div>

            <label for="review" class="block text-white text-2xl mb-3">
                <div class="p-5 bg-blue-primary">
                    Review
                </div>
                <textarea class="w-full h-40 text-black p-5 pt-2" placeholder="Write a review..." name="review" id="review" cols="30" rows="10" v-model="form.review"></textarea>
            </label>
            
            <label for="notes" class="block text-white text-2xl mb-3">
                <div class="p-5 bg-blue-primary">
                    Notes
                </div>
                <textarea class="w-full h-40 text-black p-5 pt-2" placeholder="Use this field to write down some notes such as where you saw the film, who with, film stock, etc.&#10;&#10;Only you will be able to see this" name="notes" id="notes" cols="30" rows="10" v-model="form.notes"></textarea>
            </label>

            <label for="view_date" class="block text-white text-2xl mb-3">
                <div class="p-5 bg-blue-primary">
                    Share to
                </div>
                <label v-for="(community, index) in communities" :key="index" class="flex items-center grid grid-cols-4 text-black m-5 mt-4 mb-0" :for="'community-' + index">
                    <p class="col-span-3 text-xl">{{ community.name }}</p>
                    <input class="justify-self-end" type="checkbox" :value="community.id" :id="'community-' + index" :name="'community-' + index">
                </label>
            </label>
            <div class="w-full text-center bg-green fixed bottom-16">
                <input class="bg-green p-5 text-3xl text-white" type="submit" value="Confirm">
            </div>
        </form>
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
            };
        },
        setup(){
            const form = reactive({
                search_movie: null,
            })

            function submit(){
                Inertia.post('/movie/search', form)
            }

            return { form, submit }
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
            }
        },
    };
</script>
