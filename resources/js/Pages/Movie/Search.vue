<template>
    <app-layout>

        <form @submit.prevent = "submit" class="hidden w-64 md:inline-block flex items-center relative m-5">
            <input
                class="rounded-full w-full h-14 pl-6 pr-12 text-sm border-2 focus:border-4 focus:border-blue-primary border-blue-primary rounded-full "
                    type="search" name="search_movie" id="search_movie" v-model="form.search_movie"
                placeholder="Search movies"
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

        <template #header>
            <h2 v-if="search">Results for "{{ search }}"</h2>
            <h2 v-else>Please enter your search in the search box</h2>
        </template>

        <inertia-link :href="'/movie/' + result.id" v-for="(result, index) in results" :key="index" class="m-5 flex items-center">
            <div class="pb-24 pl-16 bg-center bg-cover bg-blue-primary" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + result.poster_path + ')'}"></div>
            <div class="ml-5">
                <h3 class="text-2xl mb-4">
                    {{ result.title }}
                </h3>
                <p v-if="result.release_date" class="text-2xl">({{ result.release_date.substring(0, 4) }})</p>
                <p v-else class="text-2xl">(tbd)</p>
            </div>
        </inertia-link>

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
            results: {
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
