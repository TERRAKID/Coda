<template>
    <jet-authentication-card>
        <h2 class="text-black text-2xl mb-8">Sign up</h2>
        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-input
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Username"
                />
            </div>

            <div class="mt-4">
                <jet-input
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    placeholder="Email"
                />
            </div>

            <div class="mt-4">
                <jet-input
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="Password"
                />
            </div>

            <div class="mt-4">
                <jet-input
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm Password"
                />
            </div>

            <div
                class="mt-4"
                v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
            >
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox
                            name="terms"
                            id="terms"
                            v-model:checked="form.terms"
                        />

                        <div class="ml-2 text-black text-base">
                            I agree to the
                            <a
                                target="_blank"
                                :href="route('terms.show')"
                                class="underline text-black text-opacity-50 hover:text-opacity-100"
                                >Terms of Service</a
                            >
                            and
                            <a
                                target="_blank"
                                :href="route('policy.show')"
                                class="underline text-black text-opacity-50 hover:text-opacity-100"
                                >Privacy Policy</a
                            >
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex flex-col items-center mt-8 gap-8">
                <jet-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Join now
                </jet-button>
                <inertia-link
                    :href="route('login')"
                    class="underline text-black text-opacity-50 hover:text-opacity-100"
                >
                    Already have an account?
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

        data() {
            return {
                form: this.$inertia.form({
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                    terms: false,
                }),
            };
        },

        methods: {
            submit() {
                this.form.post(this.route("register"), {
                    onFinish: () =>
                        this.form.reset("password", "password_confirmation"),
                });
            },
        },
    };
</script>
