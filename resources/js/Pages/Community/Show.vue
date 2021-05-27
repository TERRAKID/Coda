<template>
    <app-layout>
        <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ this.activeCommunity.name }}
        </h2>
        </template>

    <div style="background-image: url('/storage/{{ this.activeCommunity.background_photo_path }}')">
        <div>
            <img v-bind:src="'/storage/' + this.activeCommunity.community_photo_path" alt="" style="max-height: 200px;">
        </div>
        <div>
            <div v-if="this.isMember == true">
                <a class="link details-link" v-bind:href="'/community/' + this.activeCommunity.id + '/details'"><div class="link-btn">
                        <p class="link-btn-text">i</p>
                </div></a>

                <input id="invite-btn" type="button" value="Invite Friends">
            </div>

            <div v-else>
                <a class="link join-link" v-bind:href="'/community/' + this.activeCommunity.id + '/invite'"><div class="link-btn">
                        <p class="link-btn-text">Join Community</p>
                </div></a>
            </div>
        </div>

    </div>

    <div style="display: none" id="invite-popup">
        <h2>Send this link to your friends to invite them to {{ this.activeCommunity.name }}</h2>
        <p id="invite-url">{{ url()->current() }}/invite</p>
        <input id="invite-close" type="button" value="Close">
    </div>
    </app-layout>
</template>