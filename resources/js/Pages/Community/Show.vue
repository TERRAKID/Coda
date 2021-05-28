<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ community.name }}
            </h2>
        </template>
        <div :style="styles">
            <div>
                <img v-bind:src="'/storage/' + community.community_photo_path" alt="" style="max-height: 200px;">
            </div>
            <div>
                <div v-if="this.isMember == true">
                    <a class="link details-link" v-bind:href="'/community/' + this.community.id + '/details'"><div class="link-btn">
                            <p class="link-btn-text">i</p>
                    </div></a>

                    <input id="invite-btn" type="button" value="Invite Friends">
                </div>

                <div v-else>
                    <a v-on:click="inviteVis = !inviteVis" class="link join-link"><div class="link-btn">
                            <p class="link-btn-text">Join Community</p>
                    </div></a>
                </div>
            </div>
        </div>
        <div id="invite-popup">
            <h2>Send this link to your friends to invite them to {{ this.community.name }}</h2>
            <p id="invite-url">coda.app/community/{{ this.community.id }}/invite</p>
            <input id="invite-close" type="button" value="Close">
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
            communityBanner: 'url({{this.community.community_photo_path}})',
            inviteVis: false,
            avatarURL: null,
            bannerURL: null,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    styles(){
        return{
            'background-image': 'url(${this.community.community_photo_path})',
        }
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
        }
    },
    methods: {

    }
}
</script>