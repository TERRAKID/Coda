<template>
    <app-layout>
        <template #header>
            <h1>Hey {{ this.user.name }}, here are all your communities</h1>
        </template>
        <div class="text-center">
            <inertia-link v-for="(community, index) in communities" :key="index" :href="'community/' + community.id" class="text-center inline-block w-40 mt-5 ml-5">
                <div class="rounded-full border-blue-primary border-4 bg-cover bg-center h-24 w-24 inline-block m-3" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
                <h3 class="text-lg truncate">{{ community.name }}</h3>
            </inertia-link>
        </div>
        <div class="w-full text-center">
            <inertia-link href="/community/create"><input type="button" value="Create New +" class="cursor-pointer transition-all duration-200 bg-green hover:bg-greenDark text-white p-3 pl-10 pr-10 text-2xl m-10 rounded-full"></inertia-link>
        </div>
    </app-layout>
</template>

<script type="text/javascript">
    import AppLayout from "@/Layouts/AppLayout";
    import { reactive } from "vue";

    export default {
        components: {
            AppLayout,
        },
        data() {
            return {};
        },
        props: {
            communities: {
                type: Array,
                required: true,
            },
            user: {
                type: Array,
                required: true,
            },
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {},
    };
</script>
