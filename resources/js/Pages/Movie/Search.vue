<template>
    <app-layout>
        <template #header>
            <h2>Movie Search</h2>
        </template>
        <form @submit.prevent = "submit">
            <label for="search_movie">Search for a Movie</label>
            <input type="search" name="search_movie" id="search_movie" v-model="form.search_movie">
            <button type="submit">Submit</button>
        </form>

        <inertia-link :href="'/diary/' + result.id + '/create'" v-for="(result, index) in results" :key="index" class="m-5 flex items-center">
            <div class="h-24 w-16 bg-center bg-cover" :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + result.poster_path + ')'}"></div>
            <div class="ml-5">
                <h3 class="text-2xl mb-4">
                    {{ result.title }} ({{ result.release_date.substring(0, 4) }})
                </h3>
                <p class="text-xl">Genre, Genre</p>
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
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {
        },
    };
</script>
