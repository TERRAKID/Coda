<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create a new community
            </h2>
        </template>
        <form action="/community/create" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" :value="csrf">
            <div id="img_uploads">
                <div>
                    <div>
                        <img id="display-avatar-preview" v-if="avatarURL" :src="avatarURL" alt="" style="max-height: 150px;">
                    </div>
                    <div id="avatar-div">
                        <label for="avatar">Upload Avatar</label>
                        <input @change="avatarChange" type="file" id="avatar" name="avatar" placeholder="Upload Avatar">
                        <input type='button' id='remove-avatar' value='Remove File' v-show="visible">
                    </div>
                </div>
                <div>
                    <div>
                        <img id="display-banner-preview" v-if="bannerURL" :src="bannerURL" alt="" style="max-height: 150px;">
                    </div>
                    <div>
                        <label for="banner">Upload Banner</label>
                        <input @change="bannerChange" type="file" id="banner" name="banner" placeholder="Upload Banner">
                        <input type='button' style="display: none;" ref="removeBanner" id='remove-banner' value='Remove File'>
                    </div>
                </div>
            </div>

            <div id="community_details">
                <div>
                    <label for="name">Community Name</label>
                    <input type="text" name="name" placeholder="Name">
                </div>
                <div>
                    <label for="visibility">Community Visibility</label>
                    <select name="visibility" id="community_visibility">
                        <option value="1">Public</option>
                        <option value="0">Private</option>
                    </select>
                </div>
                <div>
                    <h2 for="invite">Invite Your Friends</h2>
                    <div v-for="(friend, index) in friends" :key="index">
                        <label :for="'invitee-' + index">{{ friend.name }}</label>
                        <input type="checkbox" :value="friend.id" :id="'invitee-' + index" :name="'invitee-' + index">
                    </div>
                </div>
            </div>
            <input id="submit" type="submit" value="Create Community">
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
        }
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