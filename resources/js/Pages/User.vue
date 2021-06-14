<template>
    <app-layout>
        <div
            class="bg-cover bg-center bg-fixed"
            :style="[
                otherUser.profile_info &&
                otherUser.profile_info.background_photo_path
                    ? {
                          backgroundImage:
                              'url(https://image.tmdb.org/t/p/w1280' +
                              otherUser.profile_info.background_photo_path +
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
                    class="
                        md:border-b
                        border-black
                        md:p-8
                        flex
                        justify-between
                        items-end
                        md:items-center
                        flex-col-reverse
                        md:flex-row
                    "
                >
                    <div class="bg-opacity-60 md:w-2/5">
                        <div class="grid grid-cols-user items-center gap-4">
                            <div
                                class="
                                    items-center
                                    justify-self-center
                                    md:row-span-2
                                    md:self-start
                                "
                            >
                                <!-- Profile Photo -->
                                <div class="md:row-span-2">
                                    <div
                                        class="
                                            flex
                                            text-sm
                                            border-8 border-black
                                            rounded-full
                                            items-center
                                            justify-center
                                        "
                                    >
                                        <div>
                                            <img
                                                :src="
                                                    otherUser.profile_photo_url
                                                "
                                                :alt="otherUser.name"
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
                                    </div>
                                </div>
                            </div>

                            <div
                                class="
                                    text-3xl text-center
                                    md:text-xl
                                    justify-self-center
                                    md:row-start-2
                                    md:col-start-2
                                    md:justify-self-start
                                "
                            >
                                <span>{{
                                    this.amountFilms ? this.amountFilms : 0
                                }}</span>
                                <p>films</p>
                            </div>

                            <div
                                class="
                                    text-3xl text-center
                                    md:text-xl
                                    justify-self-end
                                    md:row-start-2
                                    md:col-start-2
                                "
                            >
                                <span>{{
                                    this.amountFriends ? this.amountFriends : 0
                                }}</span>
                                <p>friends</p>
                            </div>

                            <div
                                class="col-span-3 md:row-start-1 md:col-start-2"
                            >
                                <h1 class="text-3xl">{{ otherUser.name }}</h1>
                            </div>
                        </div>
                    </div>
                    <button
                        class="
                            text-center
                            px-6
                            py-1.5
                            md:px-20
                            md:py-3
                            bg-green
                            text-xs
                            md:text-xl
                            text-white
                            focus:outline-none
                            hover:bg-opacity-70
                            active:bg-opacity-60
                            disabled:opacity-25
                            transition
                            ease-in-out
                            duration-150
                            uppercase
                            rounded-full
                        "
                        type="submit"
                        @click="addFriend"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        {{ isFriend ? "Remove friend" : "Add friend" }}
                    </button>
                </div>

                <div
                    class="
                        md:bg-white
                        space-y-10
                        overflow-hidden
                        md:space-y-8
                        md:p-8
                        min-h-screen
                    "
                >
                    <p class="text-xl">
                        Favorite genre:
                        {{
                            this.favoriteGenre
                                ? this.favoriteGenre
                                : "no genre found"
                        }}
                    </p>
                    <div>
                        <p class="text-xl mb-4">My favorite movies</p>
                        <div class="flex justify-between">
                            <img
                                v-for="(favoriteMovie, index) in favoriteMovies"
                                :key="index"
                                :src="
                                    'https://image.tmdb.org/t/p/w185/' +
                                    favoriteMovie.poster_path
                                "
                                :alt="favoriteMovie.original_title"
                                class="w-1/6"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";

    export default {
        components: {
            AppLayout,
        },

        props: {
            otherUser: Object,
            isFriend: Boolean,
            amountFriends: Number,
            amountFilms: Number,
            favoriteGenre: String,
            favoriteMovies: Object,
        },

        data() {
            return {
                form: this.$inertia.form({
                    friendId: this.otherUser.id,
                    isFriend: this.isFriend,
                }),
            };
        },

        methods: {
            addFriend() {
                this.form.post(route("addFriend"), {
                    preserveScroll: true,
                    preserveState: false,
                });
            },
        },
    };
</script>
