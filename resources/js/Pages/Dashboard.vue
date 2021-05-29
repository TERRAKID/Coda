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
                <a v-for="(community, index) in recCommunities" :key="index" :href="'/community/' + community.id">
                    <div class="rounded-full bg-cover h-40 w-40" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                </a>
            </div>
        </div>

        <div>
            <h3>
                Trending movies
            </h3>
            <div>

            </div>
        </div>

        <div>
            <h3>
                Most popular review this week
            </h3>
            <div>
                <img src="" alt="">
                <div>
                    <img src="" alt="">
                    <div>
                        <h4>
                            Will Smitters
                        </h4>
                        <p>
                            12/04/2021 - 5k likes
                        </p>
                    </div>
                </div>
                <div>
                    <p>
                        review text
                    </p>
                </div>
            </div>
        </div>

        <div>
            <h3>
                Your Community updates
            </h3>
            <div>
                <a v-for="(community, index) in communities" :key="index" :href="'/community/' + community.id">
                    <div>
                        <img :src="community.community_photo_path" alt="">
                        <p>{{ community.name }}</p>
                    </div>
                </a>
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

            }
        },
        props:{
            recCommunities: {
                type: Array,
                required: true,
            },
            review: {
                type: Array,
                required: true,
            }
        },
    }
</script>
