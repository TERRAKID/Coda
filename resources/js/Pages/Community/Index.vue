<template>
    <app-layout>
        <template #header>
            <h1>Hey, {{ this.user.name }}, here are all your communities</h1>
        </template>
        <inertia-link v-for="(community, index) in communities" :key="index" :href="'community/' + community.id">
            <div class="rounded-full bg-cover bg-center h-24 w-24 inline-block m-3" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
            <h3>{{ community.name }}</h3>
        </inertia-link>
        <inertia-link href="/community/create"><input type="button" value="Create New +"></inertia-link>
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
