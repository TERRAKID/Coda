<template>
    <jet-action-section>
        <template #content>
            <div>
                <jet-button @click="confirmLogout" class="w-full">
                    Log Out On All Devices
                </jet-button>

                <jet-action-message :on="form.recentlySuccessful" class="ml-3">
                    Done.
                </jet-action-message>
            </div>

            <!-- Log Out Other Devices Confirmation Modal -->
            <jet-dialog-modal :show="confirmingLogout" @close="closeModal">
                <template #title> Log Out On All Devices </template>

                <template #content>
                    Please enter your password to confirm you would like to log
                    out of your other browser sessions across all of your
                    devices.

                    <div class="mt-4">
                        <jet-input
                            type="password"
                            class="mt-1 block w-full"
                            placeholder="Password"
                            ref="password"
                            v-model="form.password"
                            @keyup.enter="logoutOtherBrowserSessions"
                        />

                        <jet-input-error
                            :message="form.errors.password"
                            class="mt-2"
                        />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-button
                        class="ml-2"
                        @click="logoutOtherBrowserSessions"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Log Out
                    </jet-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionMessage from "@/Jetstream/ActionMessage";
    import JetActionSection from "@/Jetstream/ActionSection";
    import JetButton from "@/Jetstream/Button";
    import JetDialogModal from "@/Jetstream/DialogModal";
    import JetInput from "@/Jetstream/Input";
    import JetInputError from "@/Jetstream/InputError";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";

    export default {
        props: ["sessions"],

        components: {
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingLogout: false,

                form: this.$inertia.form({
                    password: "",
                }),
            };
        },

        methods: {
            confirmLogout() {
                this.confirmingLogout = true;

                setTimeout(() => this.$refs.password.focus(), 250);
            },

            logoutOtherBrowserSessions() {
                this.form.delete(route("other-browser-sessions.destroy"), {
                    preserveScroll: true,
                    onSuccess: () => this.$parent.logout(),
                    onError: () => this.$refs.password.focus(),
                    onFinish: () => this.form.reset(),
                });
            },

            closeModal() {
                this.confirmingLogout = false;

                this.form.reset();
            },
        },
    };
</script>
