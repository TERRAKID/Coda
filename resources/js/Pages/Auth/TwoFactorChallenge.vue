<template>
    <jet-authentication-card>
        <h2 class="text-black text-2xl mb-8">Two-factor authentication</h2>

        <div class="mb-4 text-black">
            <template v-if="!recovery">
                Please confirm access to your account by entering the
                authentication code provided by your authenticator application.
            </template>

            <template v-else>
                Please confirm access to your account by entering one of your
                emergency recovery codes.
            </template>
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div v-if="!recovery">
                <jet-input
                    ref="code"
                    type="text"
                    inputmode="numeric"
                    class="mt-1 block w-full"
                    v-model="form.code"
                    autofocus
                    autocomplete="one-time-code"
                    placeholder="Code"
                />
            </div>

            <div v-else>
                <jet-input
                    ref="recovery_code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.recovery_code"
                    autocomplete="one-time-code"
                    placeholder="Recovery Code"
                />
            </div>

            <div class="flex flex-col items-center mt-8 gap-8">
                <jet-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </jet-button>

                <button
                    type="button"
                    class="underline text-black text-opacity-50 hover:text-opacity-100 cursor-pointer"
                    @click.prevent="toggleRecovery"
                >
                    <template v-if="!recovery"> Use a recovery code </template>

                    <template v-else> Use an authentication code </template>
                </button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
    import JetButton from "@/Jetstream/Button";
    import JetInput from "@/Jetstream/Input";
    import JetLabel from "@/Jetstream/Label";
    import JetValidationErrors from "@/Jetstream/ValidationErrors";

    export default {
        components: {
            JetAuthenticationCard,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
        },

        data() {
            return {
                recovery: false,
                form: this.$inertia.form({
                    code: "",
                    recovery_code: "",
                }),
            };
        },

        methods: {
            toggleRecovery() {
                this.recovery ^= true;

                this.$nextTick(() => {
                    if (this.recovery) {
                        this.$refs.recovery_code.focus();
                        this.form.code = "";
                    } else {
                        this.$refs.code.focus();
                        this.form.recovery_code = "";
                    }
                });
            },

            submit() {
                this.form.post(this.route("two-factor.login"));
            },
        },
    };
</script>
