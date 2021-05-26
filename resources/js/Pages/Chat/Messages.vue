
<template>
    <div v-for="(message, index) in messages" :key="index">
        <message :message="message" :user="user" />
    </div>
</template>

<script>
    import Message from "./Message.vue";
    export default {
        components: { Message },
        props: ["messages", "user"],
    };
</script>
