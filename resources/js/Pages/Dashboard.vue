<template>
    <app-layout>
        <div class="md:grid grid-cols-4 gap-5">
        <main class="col-span-3">
            <div>
                <h3 class="mt-5 ml-5 text-lg">
                    Recommended Communities or <a class="text-white bg-blue-primary p-2 pl-3 pr-3 rounded-full" href="community/create">Create a new one <span class="text-2xl">></span></a>
                </h3>
                <div class="content-between ml-2 mt-3">
                    <inertia-link v-for="(community, index) in recCommunities" :key="index" :href="'/community/' + community.id">
                        <div class="rounded-full bg-cover h-24 w-24 inline-block m-3" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                    </inertia-link>
                </div>
            </div>

            <div>
                <h3 class="mt-5 ml-5 text-lg">
                    Trending movies
                </h3>
                <div class="content-between ml-2 mt-3">
                    <img class="w-32 inline-block m-3" :src="poster" alt="">
                    <img class="w-32 inline-block m-3" :src="poster" alt="">
                    <img class="w-32 inline-block m-3" :src="poster" alt="">
                    <img class="w-32 inline-block m-3" :src="poster" alt="">
                    <img class="w-32 inline-block m-3" :src="poster" alt="">
                </div>
            </div>

            <div class="mt-5 ml-5 text-lg">
                <h3>
                    Most popular review this week
                </h3>
                <div class="grid grid-cols-4 grid-rows-1 mt-8">
                    <img class="max-w-3/4 inline-block row-span-full col-span-1" id="reviewPoster" :src="poster" alt="">
                    <div class="col-span-3 grid grid-rows-6 grid-cols-1 gap-4">
                        <div class="row-span-1">
                            <img id="userAvatar" :src="'/storage/' + review.profile_photo_path" alt="">
                            <div>
                                <h4>
                                    {{ review.name }}
                                </h4>
                                <p>
                                    {{ friendlyDate(review.created_at) }} - 5k likes
                                </p>
                            </div>
                        </div>
                        <div class="row-span-5">
                            <p>
                                {{ review.review }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <aside class="w-full text-center mt-5 pr-5">
            <h3>
                Your Community updates
            </h3>
            <div>
                <inertia-link v-for="(community, index) in userCommunities" :key="index" :href="'/community/' + community.id" class="m-5 text-white">
                    <div class="grid grid-cols-6 gap-4 flex items-center justify-center bg-blue-primary rounded-bl-full rounded-tl-full rounded-tr-2xl rounded-br-2xl">
                        <div class="rounded-full bg-cover h-24 w-24 inline-block col-span-2" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                        <p class="w-full col-span-4 pr-5">{{ community.name }}</p>
                    </div>
                </inertia-link>
            </div>
        </aside>
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
