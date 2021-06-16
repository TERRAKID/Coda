<template>
    <app-layout>
        <form class="max-w-full" @submit.prevent="onSubmit()">
            <header 
                class="lg:grid grid-cols-2 bg-green bg-center bg-cover max-w-full pl-10" 
                :style="{'background-image':'linear-gradient(rgba(59, 186, 192, 0.5), rgba(59, 186, 192, 0.5)), url(' + bannerURL + ')'}">

                <div class="flex flex-col lg:flex-row">
                    <div 
                        class="bg-cover bg-center w-28 h-28 rounded-full bg-blue-primary m-4 ml-0" 
                        :style="{'background-image':'url(' + avatarURL + ')'}">
                    </div>

                    <div class="lg:ml-6 lg:mt-14 mt-5">

                        <label class="w-60 max-h-14 cursor-pointer bg-blue-primary p-3 pl-10 pr-10 text-lg text-white text-center rounded-xl" for="avatar">Upload avatar 
                            <img class="w-7 inline-block" src="/img/upload.svg" alt="">
                            <input ref="avatar" class="hidden" @change="avatarChange" type="file" id="avatar" name="avatar" placeholder="Upload Avatar">
                        </label>
                        <input type='button' id='remove-avatar' value='Remove File' v-show="visible">
                    </div>
                </div>

                <div class="justify-self-end content-center inline-block">
                    <div class="mt-14 lg:mr-10 pb-10">
                        <label class="w-60 max-h-14 cursor-pointer bg-blue-primary p-3 pl-10 pr-10 text-lg text-white text-center rounded-xl" for="banner">Upload Banner
                            <img class="w-7 inline-block" src="/img/upload.svg" alt="">
                            <input ref="banner" class="hidden" @change="bannerChange" type="file" id="banner" name="banner" placeholder="Upload Banner">
                        </label>
                        <input type='button' style="display: none;" ref="removeBanner" id='remove-banner' value='Remove File'>
                    </div>
                </div>
            </header>

            <main class="m-10 mt-5">
            <div id="community_details">
                <p v-if="this.errors.length" class="m-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    {{ this.errors[0] }}
                </p>
                <div v-if="this.success.length" class="m-5 bg-successGreen text-successGreenBorder border border-successGreenBorder text-green-700 px-4 py-3 rounded " >
                    <p role="alert">Community created successfully.</p>
                    <p>Returning you to all communities...</p>
                </div>
                <div>
                    <label for="name" class="text-black text-2xl mb-8">Community Name</label>
                    <input v-model="name" type="text" name="name" placeholder="Name" class="lg:max-w-1/4 border-2 border-green focus:border-green focus:ring-2 focus:ring-green rounded-lg text-xl mt-5 block w-full">
                </div>
                <div class="mt-10 mb-10">
                    <label for="visibility" class="text-black text-2xl mb-8 mr-5">Community Visibility</label>
                    <div class="inline-block mt-5 lg:mt-0">
                        <div class="inline-block mr-5">
                            <label class="cursor-pointer bg-blue-primary p-3 pl-16 text-lg pr-16 lg:ml-10 text-white text-center rounded-xl" v-bind:class="[isActive ? 'opacity-100' : 'opacity-60']">
                                Public
                                <input @click="visSelect" class="hidden" type="radio" name="visibility" id="community_visibility" value="1" v-model="visibility">
                            </label>
                        </div>
                        <div class="inline-block mt-10 sm:mt-0">
                            <label class="cursor-pointer bg-blue-primary p-3 pl-16 text-lg pr-16 lg:ml-10 md:ml-5 text-white text-center rounded-xl opacity-60" v-bind:class="[isActive ? 'opacity-60' : 'opacity-100']">
                                Private
                                <input @click="visSelect" class="hidden" type="radio" name="visibility" id="community_visibility" value="0" v-model="visibility">
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 for="invite" class="text-black text-2xl mb-8">Invite Your Friends</h2>
                    <div v-if="this.friends != null" >
                        <label v-for="(friend, index) in friends.slice(0, 5)" :key="index" class="flex grid grid-cols-4 lg:grid-cols-10 mb-5 mr-5 min-w-min max-w-64" :for="'invitee-' + index">
                            <div class="rounded-full bg-blue-primary bg-cover h-16 w-16 inline-block" :style="{'background-image':'url(' + friend.profile_photo_url + ')'}"></div>
                            <p class="p-5 pl-0 grid col-span-2">{{ friend.name }}</p>
                            <input class="mt-6" type="checkbox" :value="friend.id" :ref="'invite' + index" :id="'invitee-' + index" :name="'invitee-' + index">
                        </label>
                    </div>
                    <div v-else>
                        <h3>You do not have any friends at the moment.</h3>
                    </div>
                </div>
            </div>
            <div v-if="error">
                {{ error.response.status }}
            </div>
            <div class="w-full text-center">
                <input class="cursor-pointer transition-all duration-200 bg-green hover:bg-greenDark text-white p-3 pl-10 pr-10 text-2xl rounded-full" id="submit" type="submit" value="Create Community">
            </div>
            </main>
        </form>
    </app-layout>
</template>

<script type="text/javascript">
import AppLayout from "@/Layouts/AppLayout";
import {reactive} from 'vue';
import axios from 'axios';

export default{
    components: {
        AppLayout,
    },
    data(){
        return{
            visible: false,
            avatarURL: null,
            bannerURL: null,
            visibility: "1",
            isActive: true,
            errors: [],
            success: [],
        }
    },
    props: {
        friends: {
            type: Array,
            required: false,
        },
        hasFriends: {
            type: String,
            required: true,
        },
        communityId: {
            type: Number,
            required: false,
        }
    },
    methods: {
        avatarChange(e){
            const avatar = e.target.files[0];
            if(avatar.size > 2048 * 2048){
                this.errors = [];
                this.errors.push("The community avatar must be less than 2mb");
            }
            else{
                this.avatarURL = URL.createObjectURL(avatar);
            }
        },
        bannerChange(e){
            const banner = e.target.files[0];
            if(banner.size > 2048 * 2048){
                this.errors = [];
                this.errors.push("The community banner must be less than 2mb");
            }
            else{
                this.bannerURL = URL.createObjectURL(banner);
            }
        },
        visSelect(e){
            this.isActive = !this.isActive;
        },
        onSubmit() {
            let formData = new FormData();
            if(this.$refs.avatar.files[0]){
                if(this.$refs.avatar.files[0].size > 2048 * 2048){
                    this.errors = [];
                    this.errors.push("The community avatar must be less than 2mb");
                }
                else{
                    formData.append('avatar', this.$refs.avatar.files[0]);
                }
            }
            if(this.$refs.banner.files[0]){
                if(this.$refs.banner.files[0].size > 2048 * 2048){
                    this.errors = [];
                    this.errors.push("The community banner must be less than 2mb");
                }
                else{
                    formData.append('banner', this.$refs.banner.files[0]);
                }
            }
            formData.append('name', this.name);
            formData.append('visibility', this.visibility);
            
            
            for(this.x = 0; this.x < 5; this.x++){
                if(document.getElementById('invitee-' + this.x) != null){
                    let invitedUser = document.getElementById('invitee-' + this.x)
                    if(invitedUser.checked == true){
                        formData.append('invitee-' + this.x, invitedUser.value);
                    }
                }
            }
            
            this.errors = [];
            if(!this.name){
                this.errors.push("Please enter a name for your community");
                window.scrollTo({ top: 0, behavior: "smooth" });
            }
            else{
                axios
                    .post("/community/create", formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                    })
                    .then((res) => {
                        if (res.status === 200) {
                            this.success.push("Created community successfully. Redirecting you to all communities...");
                            window.scrollTo({ top: 0, behavior: "smooth" });
                            setTimeout(() => {  window.location.href = "/community"; }, 2000);
                            
                        }
                    })
                    .catch((err) => {
                        this.errors = [];
                        this.errors.push("Something went wrong, please try again later");
                        window.scrollTo({ top: 0, behavior: "smooth" });
                    });
            }
        }
    },
}
 
</script>