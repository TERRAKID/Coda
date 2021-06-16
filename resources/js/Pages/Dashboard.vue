<template>
    <app-layout>
        <div class="md:grid grid-cols-6 gap-5">
            <div class="md:col-span-4">
                <h2 class="mt-5 ml-5 text-xl">
                    Recommended Communities or <inertia-link class="text-white bg-blue-primary p-2 pl-3 pr-3 rounded-full inline-block" href="community/create">Create a new one <span class="text-2xl">></span></inertia-link>
                </h2>
                <div class="content-between ml-2 mt-3">
                    <inertia-link v-for="(community, index) in recCommunities" :key="index" :href="'/community/' + community.id">
                        <div class="rounded-full bg-cover bg-center h-24 w-24 inline-block m-3" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                    </inertia-link>
                </div>
            </div>
            <div class="max-w-full md:text-center ml-5 mt-5 pr-5 md:col-start-5 md:col-end-7 md:row-span-2">
                <div class="max-w-full md:text-center mt-5 pr-5">
                    <h2 class="text-xl">
                        Your Communities
                    </h2>
                    <div v-if="userCommunities != null" class="flex justify-items-center flex-col">
                        <inertia-link v-for="(community, index) in userCommunities" :key="index" :href="'/community/' + community.community_id" class="m-2 text-white">
                            <div class="bg-blue-primary rounded-tl-large rounded-bl-large rounded-tr-2xl rounded-br-2xl flex items-center text-right md:h-20 md:text-center lg:h-auto lg:text-right">
                                <div class="p-10 inline-block rounded-full bg-cover bg-center md:hidden lg:inline-block" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                                <p class="w-full mr-5 truncate md:hidden lg:inline-block">{{ community.name }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div v-else>
                        <h3 class="mt-5 text-gray-400">You are not a member of any communities at the moment.</h3>
                    </div>
                </div>
                <div class="max-w-full md:text-center pr-5 mt-12">
                    <h2 class="text-xl">
                        Your Community Invites
                    </h2>
                    <div v-if="inviteCommunities" class="flex justify-items-center flex-col">
                        <inertia-link v-for="(community, index) in inviteCommunities" :key="index" :href="'/community/' + community.community_id" class="m-2 text-white">
                            <div class="bg-blue-primary rounded-tl-large rounded-bl-large rounded-tr-2xl rounded-br-2xl flex items-center text-right md:h-20 md:text-center lg:h-auto lg:text-right">
                                <div class="p-10 inline-block rounded-full bg-cover bg-center md:hidden lg:inline-block" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                                <p class="w-full mr-5 truncate md:hidden lg:inline-block">{{ community.name }}</p>
                            </div>
                        </inertia-link>
                    </div>
                    <div v-else>
                        <h3 class="mt-5 text-gray-400">You do not have any community invites at the moment.</h3>
                    </div>
                </div>
            </div>
            <div class="md:col-span-4">
                <h2 class="mt-5 ml-5 text-xl">
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
                <div class="flex items-center flex-wrap">
                    <h2 class="mr-5 text-xl">Most recent review</h2>
                    <inertia-link class="text-white bg-blue-primary p-2 pl-5 pr-3 rounded-full flex items-center" href="reviews/recent">Show all recent reviews<span class="text-2xl ml-2">></span></inertia-link>
                </div>
                <div class="grid grid-cols-4 grid-rows-1 mt-5 gap-8 mb-10">
                    <inertia-link :href="'/movie/' + reviewMovie.id">      
                        <img class="max-w-full inline-block row-span-full col-span-1" id="reviewPoster" :src="'https://image.tmdb.org/t/p/w500' + reviewMovie.poster_path" alt="">
                    </inertia-link>
                    <div class="col-span-3 grid-cols-1">
                        <inertia-link :href="'/user/' + review.user_id" class="row-span-1 flex flex-wrap items-center justify-between mb-8">
                            <div class="flex items-center">
                                <div class="bg-blue-primary rounded-full bg-cover bg-center h-16 w-16 inline-block mr-3" :style="{'background-image':'url('+ userDetails.profile_photo_url + ')'}"></div>
                                <div>
                                    <h3>
                                        {{ review.name }}
                                    </h3>
                                    <p>
                                        {{ friendlyDate(review.created_at) }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div v-if="review.rating < 5" class="flex m-5 mb-0 sm:m-0">
                                    <img class="w-6 sm:w-10 mr-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                                    <img class="w-6 sm:w-10 mr-2" v-for="index in 5-review.rating" :key="index" src="/img/star-outline.svg" alt="Blank Star">
                                </div>
                                <div v-else class="flex m-5 mb-0 sm:m-0">
                                    <img class="w-6 sm:w-10 mr-2" v-for="index in review.rating" :key="index" src="/img/star.svg" alt="Full Star">
                                </div>
                            </div>
                        </inertia-link>
                        <inertia-link :href="'/movie/' + reviewMovie.id + '/review/' + review.id" class="row-span-2">
                            <p v-bind:key="line" v-for="line in (review.review).split('\n')">{{line}}<br></p>
                        </inertia-link>
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
            inviteCommunities: {
                type: Array,
                required: true,
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
            },
            userDetails: {
                type: Array,
                required: false
            },
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
