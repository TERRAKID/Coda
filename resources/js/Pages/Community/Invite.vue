<template>
    <app-layout v-if="this.isMember == true">
        <template #header>
            <h1>You are already a member of {{ this.community.name }}</h1>
        </template>
        <div>
            <a v-bind:href="'/community/' + this.community.id">
                <input type="button" value="Go to community">
            </a>
        </div>
    </app-layout>
    <app-layout v-else>
        <template #header>
            <h1>You have been invited to join {{ this.community.name }}</h1>
        </template>
        <form :action="'/community/' + this.community.id + '/invite'" method="POST">
            <input type="hidden" name="_token" :value="csrf">
            <input type="submit" value="Click here to join">
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
            Inertia.post('/community' + this.community.id + '/invite', form)
        }

        return { form, submit }
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