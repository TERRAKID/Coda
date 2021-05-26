<template>
    <div>
        <ul v-for="(user, index) in users" :key="index">
            <user
                :user="user"
                :message="this.lastMessages[index]"
                @click="$emit('userchanged', user)"
                class="cursor-pointer"
            />
        </ul>
    </div>
</template>

<script>
    import User from "./User.vue";
    export default {
        components: { User },
        props: ["users", "activeUser", "lastMessages"],
        data: function () {
            return {
                selected: "",
            };
        },
        created() {
            this.selected = this.activeUser;
        },
    };
</script>
