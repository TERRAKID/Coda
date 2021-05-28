<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Community Details
            </h2>
        </template>
    <div>
        <div id="group-members">
            <div class="members-header header">
                <div>
                    <h2>Group members</h2>
                    <input type="search" name="memberSearch" id="">
                </div>
                <p></p>
            </div>
            <div id="member-list">
                <article></article>
            </div>
        </div>

        <div id="community-goals">
            <div class="goals-header header">
                <h2>Community Goals</h2>
            </div>
            <div id="goals-list">
                <article></article>
            </div>
        </div>

        <div id="movie-month">
            <div class="movie-month-header header">
                <h2>Group members</h2>
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

        <div id="polls">
            <div class="polls-header header">
                <h2>Polls</h2>
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
        
        <input v-on:click.native="confirmingUserDeletion = true" id="leave-btn" class="btn danger-btn" type="button" value="Leave Community">

        <form id="leave-community-form" :action="'/community/' + this.community.id + '/details'" method="POST">
            <input type="hidden" name="_token" :value="csrf">
            <h3>Are you sure you want to leave {{ this.community.name }}?</h3>
            <input id="leave-confirm" class="btn danger-btn" type="submit" value="Leave Community">
            <input id="leave-cancel" type="button" value="Cancel">
        </form>
        <jet-confirmation-modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
            <template #title>
                Delete Account
            </template>

            <template #content>
                Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted.
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmingUserDeletion = false">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Account
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
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
            Inertia.post('/community/' + this.community.id + '/details', form)
        }

        return { form, submit }
    },
    props: {
        community: {
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