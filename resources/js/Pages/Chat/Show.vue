<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ this.activeUser.name }}
            </h2>
            <p v-if="this.messages[0]">
                {{
                    this.messages[this.messages.length - 1].message.length > 20
                        ? this.messages[this.messages.length - 1].message.slice(
                              0,
                              20
                          ) + "..."
                        : this.messages[this.messages.length - 1].message
                }}
                -
                {{
                    (
                        "0" +
                        new Date(
                            this.messages[this.messages.length - 1].created_at
                        ).getHours()
                    ).slice(-2) +
                    ":" +
                    (
                        "0" +
                        new Date(
                            this.messages[this.messages.length - 1].created_at
                        ).getMinutes()
                    ).slice(-2)
                }}
            </p>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <users
                        v-if="activeUser.id"
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
