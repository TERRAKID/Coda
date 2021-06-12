<template>
    <app-layout>
        <div
            class="bg-cover bg-center bg-fixed"
            :style="[
                background
                    ? {
                          backgroundImage:
                              'url(https://image.tmdb.org/t/p/w1280' +
                              background +
                              ')',
                      }
                    : '',
            ]"
        >
            <div
                class="
                    p-4
                    md:p-0
                    bg-white bg-opacity-60
                    space-y-10
                    md:space-y-0
                "
            >
                <div
                    v-if="$page.props.jetstream.canUpdateProfileInformation"
                    class="md:border-b border-black md:p-8"
                >
                    <div class="bg-opacity-60 md:w-2/5">
                        <update-profile-information-form
                            :user="$page.props.user"
                        />
                    </div>
                </div>

                <div
                    class="
                        md:bg-white
                        space-y-10
                        overflow-hidden
                        md:space-y-8
                        md:p-8
                    "
                >
                    <div
                        v-if="$page.props.jetstream.canUpdatePassword"
                        class="md:w-2/5"
                    >
                        <update-password-form />
                    </div>

                    <div class="md:w-2/5">
                        <update-background-form
                            :user="$page.props.user"
                            v-on:newbackground="updateBackground"
                        />
                    </div>

                    <div
                        class="md:w-2/5"
                        v-if="
                            $page.props.jetstream
                                .canManageTwoFactorAuthentication
                        "
                    >
                        <two-factor-authentication-form />
                    </div>

                    <logout-other-browser-sessions-form
                        :sessions="sessions"
                        class="md:w-2/5"
                    />

                    <template
                        v-if="$page.props.jetstream.hasAccountDeletionFeatures"
                    >
                        <delete-user-form class="md:w-2/5" />
                    </template>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import DeleteUserForm from "./DeleteUserForm";
    import LogoutOtherBrowserSessionsForm from "./LogoutOtherBrowserSessionsForm";
    import TwoFactorAuthenticationForm from "./TwoFactorAuthenticationForm";
    import UpdatePasswordForm from "./UpdatePasswordForm";
    import UpdateProfileInformationForm from "./UpdateProfileInformationForm";
    import UpdateBackgroundForm from "./UpdateBackgroundForm";

    export default {
        props: ["sessions"],

        data: function () {
            return {
                background: null,
            };
        },

        components: {
            AppLayout,
            DeleteUserForm,
            LogoutOtherBrowserSessionsForm,
            TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
            UpdateBackgroundForm,
        },

        methods: {
            updateBackground() {
                axios.get("/user/background").then((response) => {
                    this.background = response.data;
                });
            },
        },
        created() {
            this.updateBackground();
        },
    };
</script>
