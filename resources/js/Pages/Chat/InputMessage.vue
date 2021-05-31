<template>
    <div>
        <input
            type="text"
            placeholder="Start typing..."
            v-model="message"
            @keyup.enter="sendMessage()"
        />
    </div>
</template>

<script>
    export default {
        props: ["user"],
        data: function () {
            return {
                message: "",
            };
        },
        methods: {
            sendMessage() {
                axios
                    .post("/chat/" + this.user.id, {
                        message: this.message,
                    })
                    .then((response) => {
                        if (response.status === 201) {
                            this.message = "";
                            this.$emit("messagesend");
                        }
                    });
            },
        },
    };
</script>
