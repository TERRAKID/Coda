<template>
    <app-layout>
        <div class="md:grid grid-cols-6 gap-5">
            <div class="md:col-span-4">
                <h2 class="mt-5 ml-5 text-lg">
                    Recommended Communities or <inertia-link class="text-white bg-blue-primary p-2 pl-3 pr-3 rounded-full inline-block" href="community/create">Create a new one <span class="text-2xl">></span></inertia-link>
                </h2>
                <div class="content-between ml-2 mt-3">
                    <inertia-link v-for="(community, index) in recCommunities" :key="index" :href="'/community/' + community.id">
                        <div class="rounded-full bg-cover bg-center h-24 w-24 inline-block m-3" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                    </inertia-link>
                </div>
            </div>
            <div class="max-w-full md:text-center ml-5 mt-5 pr-5 md:col-start-5 md:col-end-7 md:row-span-5">
                <h2>
                    Your Community updates
                </h2>
                <div class="flex justify-items-center flex-col">
                    <inertia-link v-for="(community, index) in userCommunities" :key="index" :href="'/community/' + community.community_id" class="m-2 text-white">
                        <div class="bg-blue-primary rounded-tl-large rounded-bl-large rounded-tr-2xl rounded-br-2xl flex items-center text-right md:h-20 md:text-center lg:h-auto lg:text-right">
                            <div class="p-10 inline-block rounded-full bg-cover bg-center md:hidden lg:inline-block" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                            <p class="w-full mr-5 truncate">{{ community.name }}</p>
                        </div>
                    </inertia-link>
                </div>
            </div>
            <div class="md:col-span-4">
                <h2 class="mt-5 ml-5 text-lg">
                    Trending movies
                </h2>
                <div class="content-between ml-5 mt-3">
                    <inertia-link v-for="(popMovie, index) in popular.slice(0, 5)" :key="index" :href="'/movie/' + popMovie.id" class="mr-4">
                        <div
                        :style="{'background-image':'url(https://image.tmdb.org/t/p/w500' + popMovie.poster_path + ')'}"
                        class="w-32 h-48 bg-cover bg-center inline-block">
                        </div>
                    </inertia-link>
                </div>
            </div>

            <div v-if="reviewStatus != '0'" class="md:col-span-4 md:row-start-3 md:row-end-5 mt-5 ml-5 text-lg">
                <h2>
                    Most recent review
                </h2>
                <div class="grid grid-cols-4 grid-rows-1 mt-3 gap-8 mb-10">
                    <img class="max-w-full inline-block row-span-full col-span-1" id="reviewPoster" :src="'https://image.tmdb.org/t/p/w500' + reviewMovie.poster_path" alt="">
                    <div class="col-span-3 grid-cols-1">
                        <div class="row-span-1 flex mb-8">
                            <div class="bg-blue-primary rounded-full bg-cover h-16 w-16 inline-block mr-3" :style="{'background-image':'url(/storage/' + review.profile_photo_path + ')'}"></div>
                            <div>
                                <h3>
                                    {{ review.name }}
                                </h3>
                                <p>
                                    {{ friendlyDate(review.created_at) }}
                                </p>
                            </div>
                        </div>
                        <div class="row-span-2">
                            <p>
                                {{ review.review }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import Welcome from "@/Jetstream/Welcome";

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        data(){
            return{
                poster: "/storage/film-posters/game-night.jpg",
            }
        },
        props: {
            recCommunities: {
                type: Array,
                required: true,
            },
            userCommunities: {
                type: Array,
                required: false,
            },
            review: {
                type: Array,
                required: false,
            },
            reviewMovie: {
                type: Array,
                required: false,
            },
            reviewStatus: {
                type: String,
            },
            popular: {
                type: Array,
                required: true,
            }
        },
        methods: {
            friendlyDate(str){
                var dateArray = str.substring(0, 10).split("-");
                dateArray.reverse();

                var date = (dateArray[0] + "/" + dateArray[1] + "/" + dateArray[2]);
                return date;
            }
        },
    }
</script>
