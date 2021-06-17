<template>
    <app-layout>
        <header class="bg-green bg-center bg-cover max-w-full flex flex-wrap items-center justify-between" :style="{'background-image':'linear-gradient(rgba(59, 186, 192, 0.5), rgba(59, 186, 192, 0.5)), url(/storage/' + this.community.background_photo_path + ')'}">
            <div class="flex content-center items-center mb-0">
                <div class="bg-cover bg-center p-12 rounded-full bg-blue-primary m-3 md:m-5" :style="{'background-image':'url(/storage/' + this.community.community_photo_path + ')'}"></div>
                <h2 class="text-white text-2xl md:text-3xl">{{ community.name }}</h2>
            </div>
            <inertia-link v-if="this.isMember == true" v-bind:href="'/community/' + this.community.id + '/details'" class="m-5 bg-white rounded-full w-10 h-full text-center mr-3 md:mr-5">
                <p class="text-blue-primary text-3xl mt-1">i</p>
            </inertia-link>
            <inertia-link v-else v-bind:href="'/community/' + this.community.id + '/invite'" class="m-5 bg-white rounded-full h-full pl-10 pr-10 text-center mr-3 md:mr-5">
                <p class="text-blue-primary text-xl m-2">Join Community</p>
            </inertia-link>
        </header>
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
            return {
                communityBanner: "url(/storage/{{this.community.community_photo_path}})",
                inviteVis: false,
                avatarURL: null,
                bannerURL: null,
                csrf: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            };
        },
        styles() {
            return {
                "background-image": "url(/storage/${this.community.community_photo_path})",
            };
        },
        props: {
            community: {
                type: Array,
                required: true,
            },
            isMember: {
                type: Array,
                required: false,
            },
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {},
    };
</script>
