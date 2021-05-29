<template>
    <jet-authentication-card>
        <h2 class="text-black text-2xl mb-8">Thanks for signing up!</h2>

        <div class="mb-4 text-black">
            Before getting started, could you verify your email address by
            clicking on the link we just emailed to you? If you didn't receive
            the email, we will gladly send you another.
        </div>

        <div class="mb-4 font-semibold text-green" v-if="verificationLinkSent">
            A new verification link has been sent to the email address you
            provided during registration.
        </div>

        <form @submit.prevent="submit">
            <div class="flex flex-col items-center mt-8 gap-8">
                <jet-button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Resend Verification Email
                </jet-button>

                <inertia-link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="underline text-black text-opacity-50 hover:text-opacity-100"
                    >Log Out</inertia-link
                >
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from "@/Jetstream/AuthenticationCard";
    import JetButton from "@/Jetstream/Button";

    export default {
        components: {
            JetAuthenticationCard,
            JetButton,
        },

        props: {
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form(),
            };
        },

        methods: {
            submit() {
                this.form.post(this.route("verification.send"));
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === "verification-link-sent";
            },
        },
    };
</script>
