<template>
    <app-layout>
        <div class="bg-blue-primary ">
        <form @submit.prevent = "submit" class="hidden w-64 md:inline-block flex items-center relative m-5 w-9/10">
            <input autofocus ref="search"
                class="rounded-full w-full h-14 pl-6 pr-12 text-sm border-2 focus:border-4 focus:border-blue-primary border-blue-primary rounded-full "
                    type="search" name="search_movie" id="search_movie" v-model="form.search_movie"
                placeholder="Search movies, users, communities"
            />
            <button
                class="focus:outline-none w-12 h-12 flex items-center justify-center absolute right-0 top-0 mt-1 mr-3"
            >
                <svg
                    class="h-1/2"
                    xmlns="http://www.w3.org/2000/svg"
                    width="371.39"
                    height="265.82"
                    viewBox="0 0 371.39 265.82"
                >
                    <circle
                        cx="251.87"
                        cy="119.52"
                        r="102.02"
                        fill="none"
                        stroke="#3865ae"
                        stroke-miterlimit="10"
                        stroke-width="35px"
                    />
                    <rect
                        x="70.07"
                        y="112.33"
                        width="38.2"
                        height="196.07"
                        rx="19.1"
                        transform="translate(234.82 34.33) rotate(62.58)"
                        fill="#3865ae"
                    />
                </svg>
            </button>
        </form>
        </div>
        <template #header>
            <h2 v-if="search">Results for "{{ search }}"</h2>
            <h2 v-else>Please enter your search in the search box</h2>
        </template>
        
        <div class="p-5 w-full text-2xl" v-if="users != null">
            <h3 class="border-b-2 border-blue-primary w-full">Users</h3>
            <inertia-link :href="'/user/' + user.id" v-for="(user, index) in users" :key="index" class="m-5 flex items-center">
                <div class="pb-16 pl-16 rounded-full bg-center bg-cover bg-blue-primary" :style="{'background-image':'url(' + user.profile_photo_url + ')'}"></div>
                <div class="ml-5">
                    <h3 class="text-2xl">
                        {{ user.name }}
                    </h3>
                </div>
            </inertia-link>
        </div>

        <div class="p-5 w-full text-2xl" v-if="communities != null">
            <h3 class="border-b-2 border-blue-primary w-full">Communities</h3>
            <inertia-link :href="'/community/' + community.id" v-for="(community, index) in communities" :key="index" class="m-5 flex items-center">
                <div class="pb-16 pl-16 rounded-full bg-center bg-cover bg-blue-primary" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                <div class="ml-5">
                    <h3 class="text-2xl">
                        {{ community.name }}
                    </h3>
                </div>
            </inertia-link>
        </div>

        <div class="p-5 w-full text-2xl" v-if="movies != null">
            <h3 class="border-b-2 border-blue-primary w-full">Movies</h3>
            <inertia-link :href="'/movie/' + movie.id" v-for="(movie, index) in movies" :key="index" class="m-5 flex items-center">
                <div class="pb-24 pl-16 bg-center bg-cover bg-blue-primary" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + movie.poster_path + ')'}"></div>
                <div class="ml-5">
                    <h3 class="text-2xl mb-4">
                        {{ movie.title }}
                    </h3>
                    <p v-if="movie.release_date" class="text-2xl">({{ movie.release_date.substring(0, 4) }})</p>
                    <p v-else class="text-2xl">(tbd)</p>
                </div>
            </inertia-link>
        </div>

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
            movies: {
                type: Array,
                required: false,
            },
            users: {
                type: Array,
                required: false,
            },
            communities: {
                type: Array,
                required: false,
            },
            genres: {
                type: Array,
                required: false,
            },
            search: {
                type: String,
                required: true,
            },
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {

        },
        
    };
</script>
