<template>
    <jet-authentication-card>
        <h2 class="text-black text-2xl mb-8">Sign in</h2>
        <jet-validation-errors class="mb-4" />

        <div v-if="status" class="mb-4 font-semibold text-green">
            {{ status }}
        </div>

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

            <div class="mt-4">
                <jet-input
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                />
            </div>

            <div class="block mt-4 flex justify-between">
                <label class="flex items-center">
                    <jet-checkbox
                        name="remember"
                        v-model:checked="form.remember"
                    />
                    <span class="ml-2 text-black">Remember me</span>
                </label>

                <inertia-link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-black text-opacity-50 hover:text-opacity-100 text-right"
                >
                    Forgot your password?
                </inertia-link>
            </div>

            <div class="flex flex-col items-center mt-8 gap-8">
                <jet-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </jet-button>
                <inertia-link
                    :href="route('register')"
                    class="underline text-black text-opacity-50 hover:text-opacity-100"
                >
                    Don't have an account?
                </inertia-link>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
    import JetButton from "@/Jetstream/Button";
    import JetInput from "@/Jetstream/Input";
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from "@/Jetstream/Label";
    import JetValidationErrors from "@/Jetstream/ValidationErrors";

    export default {
        components: {
            JetAuthenticationCard,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
        },

        props: {
            canResetPassword: Boolean,
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: "",
                    password: "",
                    remember: false,
                }),
            };
        },

        methods: {
            submit() {
                this.form
                    .transform((data) => ({
                        ...data,
                        remember: this.form.remember ? "on" : "",
                    }))
                    .post(this.route("login"), {
                        onFinish: () => this.form.reset("password"),
                    });
            },
        },
    };
</script>
