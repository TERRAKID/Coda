<template>
    <jet-action-section>
        <template #title>Update Background</template>
        <template #content>
            <div class="mt-4">
                <jet-input
                    type="search"
                    class="mt-1 block w-full"
                    v-model="backgroundQuery"
                    @keyup.enter="searchBackground()"
                    placeholder="Search for a movie"
                />
                <jet-input-error class="mt-2" />
            </div>
        </template>
    </jet-action-section>
</template>

<script>
    import JetInput from "@/Jetstream/Input";
    import JetInputError from "@/Jetstream/InputError";
    import JetActionSection from "@/Jetstream/ActionSection";

    export default {
        components: {
            JetInput,
            JetInputError,
            JetActionSection,
        },

        props: ["user"],

        data: function () {
            return {
                backgroundQuery: "",
            };
        },

        methods: {
            searchBackground() {
                axios
                    .post("/user/background", {
                        backgroundQuery: this.backgroundQuery,
                    })
                    .then((response) => {
                        if (response.status === 200) {
                            this.backgroundQuery = "";
                            this.$emit("newbackground");
                        }
                    });
            },
        },
    };
</script>
