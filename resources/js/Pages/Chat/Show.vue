<template>
    <app-layout>
        <template #header>
            <div
                class="flex items-center md:pl-4 gap-4"
                @click="showingUsers = !showingUsers"
            >
                <img
                    class="
                        h-10
                        w-10
                        rounded-full
                        object-cover
                        border-2 border-black
                    "
                    :src="activeUser.profile_photo_url"
                    :alt="activeUser.name"
                />

                <div>
                    <h2 class="text-black">
                        {{
                            this.activeUser.name
                                ? this.activeUser.name
                                : "No user selected"
                        }}
                    </h2>
                    <p class="text-base text-black" v-if="!this.messages[0]">
                        No messages
                    </p>
                    <p class="text-base" v-if="this.messages[0]">
                        <span class="font-serif text-black text-opacity-50">
                            {{
                                this.messages[this.messages.length - 1].message
                                    .length > 20
                                    ? this.messages[
                                          this.messages.length - 1
                                      ].message.slice(0, 20) + "..."
                                    : this.messages[this.messages.length - 1]
                                          .message
                            }}</span
                        >
                        <span class="text-black">
                            -
                            {{
                                (
                                    "0" +
                                    new Date(
                                        this.messages[
                                            this.messages.length - 1
                                        ].created_at
                                    ).getHours()
                                ).slice(-2) +
                                ":" +
                                (
                                    "0" +
                                    new Date(
                                        this.messages[
                                            this.messages.length - 1
                                        ].created_at
                                    ).getMinutes()
                                ).slice(-2)
                            }}</span
                        >
                    </p>
                </div>
            </div>
        </template>
        <div class="overflow-hidden">
            <div
                :class="{
                    'translate-x-0': showingUsers,
                    '-translate-x-1/2 md:translate-x-0': !showingUsers,
                }"
                class="
                    transition
                    transform
                    duration-150
                    ease-in-out
                    w-dm
                    md:w-auto
                    h-dmmd
                    md:h-dm
                    grid-cols-2 grid
                    md:grid-cols-dm
                    grid-rows-dm
                    md:divide-x
                    divide-black divide-opacity-40
                "
            >
                <users
                    :users="users"
                    :lastMessages="lastMessages"
                    :activeUser="activeUser"
                    v-on:userchanged="getActiveUser($event)"
                />
                <messages :messages="messages" :user="activeUser" />
                <input-message
                    :user="activeUser"
                    v-on:messagesend="getMessages"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import Messages from "./Messages.vue";
    import InputMessage from "./InputMessage.vue";
    import Users from "./Users.vue";

    export default {
        components: {
            AppLayout,
            Messages,
            InputMessage,
            Users,
        },
        data: function () {
            return {
                users: [],
                activeUser: [],
                messages: [],
                lastMessages: [],
                showingUsers: false,
            };
        },
        watch: {
            activeUser(val, oldVal) {
                if (oldVal.id) {
                    this.disconnect(oldVal.id);
                }
                this.connect();
            },
        },
        methods: {
            getActiveUser(user) {
                this.activeUser = user;
                this.showingUsers = !this.showingUsers;
            },
            listUsers() {
                axios.get("/chat/users").then((response) => {
                    this.users = response.data;
                    this.getActiveUser(response.data[0]);
                    this.users.forEach((user) => {
                        this.getLastMessage(user.id);
                    });
                });
            },
            getMessages() {
                axios.get("chat/" + this.activeUser.id).then((response) => {
                    this.messages = response.data;
                });
            },
            getLastMessage(userId) {
                axios.get("chat/" + userId + "/last").then((response) => {
                    this.lastMessages.push(response.data);
                });
            },
            connect() {
                if (this.activeUser.id) {
                    let userIds = [this.activeUser.id, this.$page.props.user.id];
                    userIds.sort((a, b) => {
                        return a - b;
                    });
                    let vm = this;
                    this.getMessages();
                    window.Echo.private(
                        "chat." + userIds[0] + "." + userIds[1]
                    ).listen(".message.new", (e) => {
                        vm.getMessages();
                    });
                }
            },
            disconnect(userId) {
                let userIds = [userId, this.$page.props.user.id];
                userIds.sort((a, b) => {
                    return a - b;
                });
                window.Echo.leave("chat." + userIds[0] + "." + userIds[1]);
            },
        },
        created() {
            this.listUsers();
        },
    };
</script>
