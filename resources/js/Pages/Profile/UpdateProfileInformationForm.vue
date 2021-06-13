<template>
    <jet-form-section @submitted="updateProfileInformation">
        <template #form>
            <div class="grid grid-cols-user items-center gap-4">
                <div
                    class="
                        items-center
                        justify-self-center
                        md:row-span-3
                        md:self-start
                    "
                >
                    <!-- Profile Photo -->
                    <div
                        v-if="$page.props.jetstream.managesProfilePhotos"
                        class="md:row-span-3"
                    >
                        <!-- Profile Photo File Input -->
                        <input
                            type="file"
                            class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview"
                        />

                        <button
                            class="
                                flex
                                text-sm
                                border-8 border-black
                                rounded-full
                                focus:outline-none
                                active:ring-4 active:ring-black
                                transition
                                duration-150
                                ease-in-out
                                items-center
                                justify-center
                            "
                            type="button"
                            @click.prevent="PhotoEvent"
                        >
                            <div v-show="!photoPreview">
                                <img
                                    :src="user.profile_photo_url"
                                    :alt="user.name"
                                    class="
                                        h-24
                                        w-24
                                        rounded-full
                                        object-cover
                                        md:h-32
                                        md:w-32
                                    "
                                />
                            </div>

                            <div v-show="photoPreview">
                                <span
                                    class="
                                        block
                                        h-24
                                        w-24
                                        rounded-full
                                        object-cover
                                        md:h-32
                                        md:w-32
                                    "
                                    :style="
                                        'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                                        photoPreview +
                                        '\');'
                                    "
                                >
                                </span>
                            </div>
                        </button>
                    </div>
                </div>

                <div
                    class="
                        text-3xl text-center
                        md:text-xl
                        justify-self-center
                        md:row-start-3
                        md:col-start-2
                        md:justify-self-start
                    "
                >
                    <span>{{
                        profileInfo.amountFilms ? profileInfo.amountFilms : 0
                    }}</span>
                    <p>films</p>
                </div>

                <div
                    class="
                        text-3xl text-center
                        md:text-xl
                        justify-self-end
                        md:row-start-3
                        md:col-start-3
                    "
                >
                    <span>{{
                        profileInfo.amountFriends
                            ? profileInfo.amountFriends
                            : 0
                    }}</span>
                    <p>friends</p>
                </div>

                <!-- Name -->
                <div
                    class="
                        col-span-3
                        md:row-start-1
                        md:col-span-2 md:col-start-2
                    "
                >
                    <jet-input
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        autocomplete="name"
                        placeholder="Username"
                    />
                    <jet-input-error :message="form.errors.name" class="mt-2" />
                </div>

                <!-- Email -->
                <div
                    class="
                        col-span-3
                        md:row-start-2
                        md:col-span-2 md:col-start-2
                    "
                >
                    <jet-input
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        placeholder="Email"
                    />
                    <jet-input-error
                        :message="form.errors.email"
                        class="mt-2"
                    />
                </div>
            </div>
            <jet-input-error :message="form.errors.photo" class="mt-2" />
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Save
            </jet-button>
        </template>
    </jet-form-section>
    <p class="text-xl my-4">
        Favorite genre:
        {{
            profileInfo.favoriteGenre
                ? profileInfo.favoriteGenre
                : "no genre found"
        }}
    </p>
</template>

<script>
    import JetButton from "@/Jetstream/Button";
    import JetFormSection from "@/Jetstream/FormSection";
    import JetInput from "@/Jetstream/Input";
    import JetInputError from "@/Jetstream/InputError";
    import JetLabel from "@/Jetstream/Label";
    import JetActionMessage from "@/Jetstream/ActionMessage";
    import JetSecondaryButton from "@/Jetstream/SecondaryButton";

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ["user"],

        data() {
            return {
                form: this.$inertia.form({
                    _method: "PUT",
                    name: this.user.name,
                    email: this.user.email,
                    photo: null,
                }),

                photoPreview: null,
                profileInfo: {},
            };
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0];
                }

                this.form.post(route("user-profile-information.update"), {
                    errorBag: "updateProfileInformation",
                    preserveScroll: true,
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route("current-user-photo.destroy"), {
                    preserveScroll: true,
                    onSuccess: () => (this.photoPreview = null),
                });
            },

            PhotoEvent() {
                if (this.user.profile_photo_path) {
                    return this.deletePhoto();
                }
                return this.selectNewPhoto();
            },

            getProfileInfo() {
                axios.post(route("profileInfo"), {}).then((response) => {
                    if (response.status === 200) {
                        this.profileInfo = JSON.parse(
                            JSON.stringify(response.data)
                        );
                    }
                });
            },
        },

        created() {
            this.getProfileInfo();
        },
    };
</script>
