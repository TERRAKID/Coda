<template>
    <app-layout>
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
