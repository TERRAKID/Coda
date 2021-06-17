
<template>
    <div
        ref="messages"
        class="
            overflow-y-scroll overflow-x-hidden
            m-4
            bg-blue-primary
            h-full
            rounded-xl
            p-2
            md:px-8
            divide-y-2 divide-white divide-opacity-50
        "
    >
        <div v-for="(message, index) in messages" :key="index">
            <message :message="message" :community="community" />
        </div>
    </div>
</template>

<script>
    import Message from "./Message.vue";
    export default {
        components: { Message },
        props: ["messages", "community"],

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
