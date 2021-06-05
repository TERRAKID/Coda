<template>
    <app-layout>
        <template #header>
            <div class="grid grid-cols-2">
                <inertia-link :href="'/community/' + community.id"><img class="w-10 mt-1" src="/img/arrow.svg" alt="return to community"></inertia-link>
                <h2 class="text-2xl text-white place-self-end mb-1">
                    {{ community.name }}
                </h2>
            </div>
        </template>
    <div>
        <div class="mt-5">
            <div class="bg-purple text-white h-16 grid grid-cols-2">
                <div class="flex pl-4">
                    <h2 class="text-xl mt-4">Group members</h2>
                    <!--<input type="search" name="memberSearch" class="m-3 rounded-full text-black">-->
                </div>
                <p class="text-lg place-self-end mb-5 mr-5">{{ memberCount }}/100</p>
            </div>
            <div>
                <inertia-link v-for="(member, index) in communityMembers" :key="index" :href="'/user/' + member.id" class="m-4 inline-block w-48">
                    <div class="flex inline-block">
                        <div class="bg-blue-primary rounded-full bg-cover p-8 inline-block mr-3" :style="{'background-image':'url(/storage/' + member.profile_photo_path + ')'}"></div>
                        <p class="mt-4 text-black text-lg truncate">{{ member.name }}</p>
                    </div>
                </inertia-link>
            </div>
            <input v-on:click="inviteVis = !inviteVis" type="button" value="Invite Friends" class="cursor-pointer transition-all duration-200 bg-green hover:bg-greenDark text-white p-3 pl-10 pr-10 text-2xl rounded-full ml-4">

            <div v-show="inviteVis" v-on:click="inviteVis = !inviteVis" class="min-w-screen h-screen animated fadeIn faster fixed left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-blue-primary bg-opacity-70">
                <div v-on:click="inviteVis = !inviteVis" class="bg-white rounded-2xl h-64 p-7 text-center flex flex-col justify-center items-center">
                    <h2 class="text-xl">
                        Send this link to your friends to invite them to
                    </h2>
                    <p class="text-2xl mt-2 mb-2">{{ this.community.name }}</p>
                    <p class="mb-5 bg-gray-200 p-3 pl-5 pr-5 rounded-lg">
                        coda-app.com/community/{{ this.community.id }}/invite
                    </p>
                    <input
                        v-on:click="inviteVis = !inviteVis"
                        id="invite-close"
                        type="button"
                        value="Close"
                        class="cursor-pointer transition-all duration-200 bg-green hover:bg-greenDark text-white p-3 pl-10 pr-10 text-2xl rounded-full"
                    />
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-purple text-white flex pl-4 h-16">
                <h2 class="text-xl mt-4">Community Goals</h2>
            </div>
            <div id="goals-list">
                <article></article>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-purple text-white flex pl-4 h-16">
                <h2 class="text-xl mt-4">Group members</h2>
            </div>
            <div id="movie-month-list">
                <article>
                    <img src="" alt="">
                    <h3></h3>
                    <p></p>
                    <p></p>
                </article>
            </div>
        </div>

        <div class="mt-5">
            <div class="bg-purple text-white flex pl-4 h-16">
                <h2 class="text-xl mt-4">Polls</h2>
            </div>
            <div id="polls-list">
                <article>
                    <div class="poll-info">
                        <img src="" alt="">
                        <h3></h3>
                        <p></p>
                    </div>
                </article>
            </div>
        </div>
        <div class="w-full text-center">
            <input v-on:click="confirmingUserDeletion = !confirmingUserDeletion" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="button" value="Leave Community">
        </div>
        <form v-on:click="confirmingUserDeletion = !confirmingUserDeletion" v-show="confirmingUserDeletion" id="leave-community-form" :action="'/community/' + this.community.id + '/details'" method="POST" class="min-w-screen h-screen animated fadeIn faster fixed left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-blue-primary bg-opacity-70">
            <div v-on:click="confirmingUserDeletion = !confirmingUserDeletion" class="bg-white rounded-2xl h-64 p-5 text-center flex flex-col justify-center items-center">
                <input type="hidden" name="_token" :value="csrf">
                <h3 class="text-2xl">Are you sure you want to leave {{ this.community.name }}?</h3>
                <input id="leave-confirm" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="submit" value="Leave Community">
                <input v-on:click="confirmingUserDeletion = !confirmingUserDeletion" id="leave-cancel" type="button" value="Cancel" class="bg-white underline cursor-pointer">
            </div>
        </form>
    </div>

    </app-layout>
</template>

<script type="text/javascript">
import AppLayout from "@/Layouts/AppLayout";
import {reactive} from 'vue';

export default{
    components: {
        AppLayout,
    },
    data(){
        return{
            confirmingUserDeletion: false,
            inviteVis: false,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    setups(){
        const form = reactive({
            avatar: null,
            banner: null,
            name: null,
            visibility: null,
            inviteVis: false,
        })

        function submit(){
            Inertia.post('/community/' + this.community.id + '/details', form)
        }

        return { form, submit }
    },
    props: {
        community: {
            type: Array,
            required: true,
        },
        communityMembers: {
            type: Array,
            required: false,
        },
        memberCount: {
            type: String,
            required: false,
        },
        errors: {
            type: Array,
            required: false,
        }
    },
    methods: {
    }
}
</script>