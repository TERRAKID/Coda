<template>
    <div class="row-span-2 overflow-y-auto">
        <div v-for="(user, index) in users" :key="index">
            <user
                :user="user"
                :message="this.lastMessages[index]"
                @click="$emit('userchanged', user)"
                class="cursor-pointer"
            />
        </div>
        <p v-if="!activeUser.id" class="text-center">
            You don't have any friends yet...
        </p>
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
