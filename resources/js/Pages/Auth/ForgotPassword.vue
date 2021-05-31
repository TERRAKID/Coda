<template>
    <jet-authentication-card>
        <h2 class="text-black text-2xl mb-8">Forgot your password?</h2>

        <div class="mb-4 text-black">
            No problem. Just let us know your email address and we will email
            you a password reset link that will allow you to choose a new one.
        </div>

        <div v-if="status" class="mb-4 font-semibold text-green">
            {{ status }}
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-input
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    placeholder="Email"
                />
            </div>

            <div class="flex flex-col items-center mt-8">
                <jet-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Email Password Reset Link
                </jet-button>
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

        props: {
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: "",
                }),
            };
        },

        methods: {
            submit() {
                this.form.post(this.route("password.email"));
            },
        },
    };
</script>
