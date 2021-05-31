<template>
    <app-layout>
        <form action="/community/create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" :value="csrf">
            <header class="pl-10 bg-green bg-center bg-cover h-32 flex items-center content-between max-w-full" :style="{'background-image':'linear-gradient(rgba(59, 186, 192, 0.5), rgba(59, 186, 192, 0.5)), url(' + bannerURL + ')'}">
                <div class="flex items-center content-between">
                    <div class="bg-cover bg-center w-28 h-28 rounded-full bg-blue-primary mr-4" :style="{'background-image':'url(' + avatarURL + ')'}">
                        <!--
                        <img class="w-32 h-32 rounded-full" id="display-avatar-preview" v-if="avatarURL" :src="avatarURL" alt="" style="max-height: 150px;">
                        -->
                    </div>
                    <div id="avatar-div">
                        <label for="avatar">Upload Avatar</label>
                        <input @change="avatarChange" type="file" id="avatar" name="avatar" placeholder="Upload Avatar">
                        <input type='button' id='remove-avatar' value='Remove File' v-show="visible">
                    </div>
                </div>
                <div class="justify-self-end max-w-1/2">
                    <!--
                    <div>
                        <img id="display-banner-preview" v-if="bannerURL" :src="bannerURL" alt="" style="max-height: 150px;">
                    </div>
                    -->
                    <div>
                        <label for="banner">Upload Banner</label>
                        <input @change="bannerChange" type="file" id="banner" name="banner" placeholder="Upload Banner">
                        <input type='button' style="display: none;" ref="removeBanner" id='remove-banner' value='Remove File'>
                    </div>
                </div>
            </header>

            <main class="m-10">
            <div id="community_details">
                <div>
                    <label for="name" class="text-black text-2xl mb-8">Community Name</label>
                    <input type="text" name="name" placeholder="Name" class=" max-w-1/4 border-2 border-green focus:border-green focus:ring-2 focus:ring-green rounded-lg text-xl mt-5 block w-full">
                </div>
                <div class="mt-10 mb-10">
                    <label for="visibility" class="text-black text-2xl mb-8">Community Visibility</label>
                    <label class="cursor-pointer bg-blue-primary p-3 pl-16 text-lg pr-16 ml-10 text-white text-center rounded-xl opacity-60">
                        Public
                        <input @click="visSelect" class="hidden" type="radio" name="visibility" id="community_visibility" value="1">
                    </label>
                    <label class="cursor-pointer bg-blue-primary p-3 pl-16 text-lg pr-16 ml-10 text-white text-center rounded-xl">
                        Private
                        <input @click="visSelect" class="hidden" type="radio" name="visibility" id="community_visibility" value="0">
                    </label>
                </div>
                <div>
                    <h2 for="invite" class="text-black text-2xl mb-8">Invite Your Friends</h2>
                    <!-- there's something wrong with this if/else, coming back to it later -->
                    <div v-if="this.hasFriends == true" >
                        <div v-for="(friend, index) in friends" :key="index">
                            <label :for="'invitee-' + index">{{ friend.name }}</label>
                            <input type="checkbox" :value="friend.id" :id="'invitee-' + index" :name="'invitee-' + index">
                        </div>
                    </div>
                    <div v-else>
                        <h3>You do not have any friends at the moment.</h3>
                    </div>
                </div>
            </div>
            </main>
            <div class="absolute flex items-center justify-center">
                <input class="cursor-pointer transition-all duration-100 bg-green transform hover:scale-105 text-white p-3 pl-10 pr-10 text-2xl rounded-full" id="submit" type="submit" value="Create Community">
            </div>
        </form>
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
            visible: false,
            avatarURL: null,
            bannerURL: null,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    setups(){
        const form = reactive({
            avatar: null,
            banner: null,
            name: null,
            visibility: null,
        })

        function submit(){
            Inertia.post('/community/create', form)
        }

        return { form, submit }
    },
    props: {
        friends: {
            type: Array,
            required: false,
        },
        errors: {
            type: Array,
            required: false,
        },
        hasFriends: {
            type: String,
            required: true,
        }
    },
    methods: {
        avatarChange(e){
            const file = e.target.files[0];
            this.avatarURL = URL.createObjectURL(file);
            visible = !visible; //I can't get this to work for the life of me, will come back to it if I have time
        },
        bannerChange(e){
            const file = e.target.files[0];
            this.bannerURL = URL.createObjectURL(file);
        },
        visSelect(){
            console.log("clicked");
        },
    }
}
     
    /*$(document).ready(function (e) {

        $('#avatar').change(function(){
            $('#remove-avatar').show();
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#display-avatar-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#remove-avatar').click(function(){
            $('#display-avatar-preview').attr('src', '');
            $('#avatar').val("");
            $('#remove-avatar').hide();
        });

        $('#banner').change(function(){
            $('#remove-banner').show();
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#display-banner-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#remove-banner').click(function(){
            $('#display-banner-preview').attr('src', '');
            $('#banner').val("");
            $('#remove-banner').hide();
        });
    });*/
 
</script>