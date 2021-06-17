<template>
    <app-layout>
        <div v-if="community != null">
            <div class="grid grid-cols-2 bg-green p-5">
                <inertia-link :href="'/community/' + community.id"><img class="w-10 mt-1" src="/img/arrow.svg" alt="return to community"></inertia-link>
                <h2 class="text-2xl text-white place-self-end mb-1">
                    {{ community.name }}
                </h2>
            </div>
            <div>
                <div class="mt-5">
                    <div class="bg-purple text-white h-16 grid grid-cols-2">
                        <div class="flex pl-4">
                            <h2 class="text-xl mt-4">Group members</h2>
                        </div>
                        <p class="text-lg place-self-end mb-5 mr-5">{{ memberCount }} members</p>
                    </div>
                    <div>
                        <inertia-link v-for="(user, index) in communityMembers" :key="index" :href="'/user/' + user.id" class="m-4 inline-block w-48">
                            <div class="flex inline-block">
                                <div class="bg-blue-primary rounded-full bg-cover bg-center p-8 inline-block mr-3" :style="{'background-image':'url(' + user.profile_photo_url + ')'}"></div>
                                <p class="mt-4 text-black text-lg truncate">{{ user.name }}</p>
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

                <div class="w-full text-center">
                    <input v-on:click="confirmingUserLeave = !confirmingUserLeave" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="button" value="Leave Community">
                </div>
                <form @submit.prevent="leaveCommunity()" v-on:click="confirmingUserLeave = !confirmingUserLeave" v-show="confirmingUserLeave" id="leave-community-form" class="min-w-screen h-screen animated fadeIn faster fixed left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-blue-primary bg-opacity-70">
                    <div v-on:click="confirmingUserLeave = !confirmingUserLeave" class="bg-white rounded-2xl h-64 p-5 text-center flex flex-col justify-center items-center">
                        <h3 class="text-2xl">Are you sure you want to leave {{ this.community.name }}?</h3>
                        <input id="leave-confirm" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="submit" value="Leave Community">
                        <input v-on:click="confirmingUserLeave = !confirmingUserLeave" id="leave-cancel" type="button" value="Cancel" class="bg-white underline cursor-pointer">
                    </div>
                </form>

                <div v-if="deletePermissions == 1" class="w-full text-center">
                    <input v-on:click="confirmingCommunityDeletion = !confirmingCommunityDeletion" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="button" value="Delete">
                </div>
                <form v-if="deletePermissions == 1" @submit.prevent="deleteCommunity()" v-on:click="confirmingCommunityDeletion = !confirmingCommunityDeletion" v-show="confirmingCommunityDeletion" id="leave-community-form" class="min-w-screen h-screen animated fadeIn faster fixed left-0 top-0 flex justify-center items-center inset-0 z-50 outline-none focus:outline-none bg-blue-primary bg-opacity-70">
                    <div v-on:click="confirmingCommunityDeletion = !confirmingCommunityDeletion" class="bg-white rounded-2xl h-64 max-w-3/4 p-5 text-center flex flex-col justify-center items-center">
                        <h3 class="text-2xl">Are you sure you want to delete this community?</h3>
                        <input @click="submitForm" id="leave-confirm" class="m-5 cursor-pointer transition-all duration-200 bg-purple hover:bg-purpleDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" type="submit" value="Delete">
                        <input v-on:click="confirmingCommunityDeletion = !confirmingCommunityDeletion" id="leave-cancel" type="button" value="Cancel" class="bg-white underline cursor-pointer">
                    </div>
                </form>
            </div>
        </div>
        <div v-else>
            <div class="flex justify-between items-center bg-green p-5">
                <inertia-link :href="'/dashboard'"><img class="w-10 mt-1" src="/img/arrow.svg" alt="return to dashboard"></inertia-link>
                <h2 class="text-2xl text-white place-self-end">
                    You are not a member of this community
                </h2>
            </div>
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
            confirmingUserLeave: false,
            confirmingCommunityDeletion: false,
            inviteVis: false,
        }
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
        },
        deletePermissions: {
            type: String,
            required: true,
        },
    },
    methods: {
        deleteCommunity() {
            axios.post('/community/' + this.community.id + '/delete', {
            }).then((res) => {
                if(res.status === 200){
                    window.location.href = "/dashboard"; //there should be a better way to do this
                    this.$router.push('/dashboard');
                }
                console.log('deleted');
            }).catch((err) => {
                this.errors = [];
            })
        },
        leaveCommunity() {
            axios.post('/community/' + this.community.id + '/leave', {
            }).then((res) => {
                if(res.status === 200){
                    window.location.href = "/dashboard"; //there should be a better way to do this
                    this.$router.push('/dashboard');
                }
                console.log('left');
            }).catch((err) => {
                this.errors = [];
            })
        },
        
    }
}
</script>