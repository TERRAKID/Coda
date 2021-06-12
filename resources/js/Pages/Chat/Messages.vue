
<template>
    <div ref="messages" class="overflow-y-scroll p-4 md:py-4 md:px-8 space-y-4">
        <div v-for="(message, index) in messages" :key="index" class="">
            <message :message="message" :user="user" />
        </div>
    </div>
</template>

<script>
    import Message from "./Message.vue";
    export default {
        components: { Message },
        props: ["messages", "user"],

        methods: {
            scrollToBottom() {
                let messages = this.$refs.messages;
                messages.scrollTo({
                    top: messages.scrollHeight,
                });
            },
        },

        mounted() {
            this.scrollToBottom();
        },

        updated() {
            this.scrollToBottom();
        },

        beforeUpdate() {
            let messages = this.$refs.messages;
            messages.scrollTop = messages.scrollHeight;
        },
    };
</script>
