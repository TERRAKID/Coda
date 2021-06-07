<template>
    <div v-if="this.isMember == true" class="h-screen flex content-center">
        <div class="m-auto text-center p-10 rounded-2xl" :style="{'background-image':'linear-gradient(rgba(59, 186, 192, 0.5), rgba(59, 186, 192, 0.5)), url(' + community.background_photo_path + ')'}">
            <div class="rounded-full bg-cover bg-center h-24 w-24 inline-block col-span-2" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
            <h1 class="text-lg">You are already a member of</h1>
            <span class="text-2xl m-5 inline-block">{{ this.community.name }}</span>
            <div>
                <inertia-link v-bind:href="'/community/' + this.community.id">
                    <input class="cursor-pointer transition-all duration-100 bg-green transform hover:bg-greenDark text-white p-3 pl-10 pr-10 text-2xl rounded-xl" type="button" value="Go to community" />
                </inertia-link>
            </div>
        </div>
    </div>
    <div v-else class="h-screen flex content-center">
        <div class="m-auto text-center p-10 rounded-2xl" :style="{'background-image':'linear-gradient(rgba(59, 186, 192, 0.5), rgba(59, 186, 192, 0.5)), url(' + community.background_photo_path + ')'}">
            <div class="rounded-full bg-cover bg-center h-24 w-24 inline-block col-span-2" :style="{'background-image':'url(/storage/' + community.community_photo_path + ')'}"></div>
            <h1 class="text-lg">You have been invited to join</h1>
            <span class="text-2xl m-5 inline-block"> {{ this.community.name }}</span>
            <form :action="'/community/' + this.community.id + '/invite'" method="POST">
                <input type="hidden" name="_token" :value="csrf" />
                <input class="cursor-pointer transition-all duration-100 bg-green transform hover:bg-greenDark text-white p-2 pl-24 pr-24 text-2xl rounded-xl" type="submit" value="Join now" />
            </form>
            <div>
                <h2 class="text-lg m-5">Don't have an account?</h2>
                <inertia-link><input class="cursor-pointer transition-all duration-100 bg-green transform hover:bg-greenDark text-white p-2 pl-24 pr-24 text-2xl rounded-xl" type="submit" value="Register" /></inertia-link>
            </div>
        </div>
    </div>
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
                csrf: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            };
        },
        setups() {
            const form = reactive({
                avatar: null,
                banner: null,
                name: null,
                visibility: null,
            });

            function submit() {
                Inertia.post("/community" + this.community.id + "/invite", form);
            }

            return { form, submit };
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
