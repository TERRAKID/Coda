<template>
    <app-layout>
        <header class="grid grid-cols-2 bg-green bg-center bg-cover max-w-full" :style="{'background-image':'linear-gradient(rgba(59, 186, 192, 0.5), rgba(59, 186, 192, 0.5)), url(/storage/' + this.community.background_photo_path + ')'}">
            <div class="flex content-center items-center">
                <div class="bg-cover bg-center p-12 rounded-full bg-blue-primary m-3 md:m-5" :style="{'background-image':'url(/storage/' + this.community.community_photo_path + ')'}"></div>
                <h2 class="text-white text-2xl md:text-3xl">{{ community.name }}</h2>
            </div>
            <inertia-link v-if="this.isMember == true" v-bind:href="'/community/' + this.community.id + '/details'" class="bg-white rounded-full w-10 h-10 place-self-end text-center mb-10 mr-3 md:mb-12 md:mr-5">
                <p class="text-blue-primary text-3xl mt-1">i</p>
            </inertia-link>
            <inertia-link v-else v-bind:href="'/community/' + this.community.id + '/invite'" class="bg-white rounded-full h-11 pl-10 pr-10 place-self-end text-center mb-10 mr-3 md:mb-12 md:mr-5">
                <p class="text-blue-primary text-xl mt-2">Join Community</p>
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
