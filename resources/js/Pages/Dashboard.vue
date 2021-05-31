<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div>
            <h3>
                Recommended Communities or <a href="community/create">Create a new one <img src="" alt=""></a>
            </h3>
            <div>
                <inertia-link v-for="(community, index) in recCommunities" :key="index" :href="'/community/' + community.id">
                    <div class="rounded-full bg-cover h-40 w-40" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                </inertia-link>
            </div>
        </div>

        <div>
            <h3>
                Trending movies
            </h3>
            <div>
                <img :src="poster" alt="">
                <img :src="poster" alt="">
                <img :src="poster" alt="">
                <img :src="poster" alt="">
                <img :src="poster" alt="">
            </div>
        </div>

        <div>
            <h3>
                Most popular review this week
            </h3>
            <div>
                <img id="reviewPoster" :src="poster" alt="">
                <div>
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
                <div>
                    <p>
                        {{ review.review }}
                    </p>
                </div>
            </div>
        </div>

        <div>
            <h3>
                Your Community updates
            </h3>
            <div>
                <inertia-link v-for="(community, index) in userCommunities" :key="index" :href="'/community/' + community.id">
                    <div>
                        <div class="rounded-full bg-cover h-40 w-40" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                        <p>{{ community.name }}</p>
                    </div>
                </inertia-link>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

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
