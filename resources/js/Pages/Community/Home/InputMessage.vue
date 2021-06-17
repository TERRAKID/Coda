<template>
    <div class="p-4 pt-0 md:pb-12">
        <input
            type="text"
            placeholder="Start typing..."
            v-model="message"
            @keyup.enter="sendMessage()"
            class="
                border-black border-opacity-40
                w-full
                rounded-full
                font-detail
                px-5
                focus:outline-none
                focus:ring-2 focus:ring-green
                focus:border-green
                bg-white
            "
        />
    </div>
</template>

<script>
    export default {
        props: ["community"],
        data: function () {
            return {
                message: "",
            };
        },
        methods: {
            sendMessage() {
                axios
                    .post("/community/" + this.community.id, {
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
