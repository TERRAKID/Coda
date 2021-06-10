<template>
    <div
        :class="{
            fixed: showingNavigationDropdown,
            static: !showingNavigationDropdown,
        }"
        class="min-h-screen bg-white w-screen max-w-full md:static"
    >
        <nav class="md:fixed md:w-1/5 md:h-screen">
            <!-- Primary Navigation Menu -->
            <div class="px-4 bg-blue-primary md:hidden">
                <div class="flex justify-between h-20 gap-4">
                    <div class="flex items-center w-1/4">
                        <!-- Hamburger -->
                        <button
                            @click="
                                showingNavigationDropdown = !showingNavigationDropdown
                            "
                            class="flex text-sm border-4 border-white rounded-full focus:outline-none active:ring-2 active:ring-white transition duration-150 ease-in-out items-center justify-center"
                        >
                            <img
                                class="h-12 w-12 rounded-full object-cover"
                                :src="$page.props.user.profile_photo_url"
                                :alt="$page.props.user.name"
                            />
                        </button>
                    </div>

                    <!-- Search -->
                    <form @submit.prevent = "submit" class="flex items-center relative w-full">
                        <input
                            class="rounded-full w-full h-14 focus:outline-none focus:ring-0 border-none pl-6 pr-12 text-sm"
                             type="search" name="search_movie" id="search_movie" v-model="form.search_movie"
                            placeholder="Search movies, communities, users..."
                        />
                        <button
                            class="focus:outline-none w-12 h-12 flex items-center justify-center absolute right-0 top-0 mt-4 mr-3"
                        >
                            <svg
                                class="h-1/2"
                                xmlns="http://www.w3.org/2000/svg"
                                width="371.39"
                                height="265.82"
                                viewBox="0 0 371.39 265.82"
                            >
                                <circle
                                    cx="251.87"
                                    cy="119.52"
                                    r="102.02"
                                    fill="none"
                                    stroke="#3865ae"
                                    stroke-miterlimit="10"
                                    stroke-width="35px"
                                />
                                <rect
                                    x="70.07"
                                    y="112.33"
                                    width="38.2"
                                    height="196.07"
                                    rx="19.1"
                                    transform="translate(234.82 34.33) rotate(62.58)"
                                    fill="#3865ae"
                                />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                    'translate-x-0': showingNavigationDropdown,
                    '-translate-x-full': !showingNavigationDropdown,
                }"
                class="w-screen h-full md:w-full transition transform duration-150 ease-in-out absolute flex -translate-y-px md:static md:translate-x-0 md:translate-y-0"
            >
                <div class="bg-blue-primary w-1/2 h-full px-3 pt-3 md:w-full">
                    <!-- Responsive Settings Options -->
                    <inertia-link
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        class="hidden md:block w-3/5 m-auto"
                    >
                        <img src="/img/logo.svg" alt="Home" />
                    </inertia-link>

                    <div class="border-b border-green text-center text-white">
                        <div
                            class="flex flex-col items-center justify-center md:mt-6"
                        >
                            <div
                                class="items-center w-1/4 md:w-auto mb-3 hidden md:flex"
                            >
                                <!-- Hamburger -->
                                <div
                                    class="flex text-sm border-4 border-white rounded-full items-center justify-center"
                                >
                                    <img
                                        class="h-12 w-12 rounded-full object-cover"
                                        :src="
                                            $page.props.user.profile_photo_url
                                        "
                                        :alt="$page.props.user.name"
                                    />
                                </div>
                            </div>
                            <div class="flex flex-col justify-center">
                                <div class="font-semibold text-base">
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="text-sm">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 divide-y divide-green md:mt-0">
                            <p
                                class="hidden md:block text-left text-xl pb-3 pt-6"
                            >
                                Main
                            </p>

                            <jet-responsive-nav-link
                                :href="route('profile.show')"
                                :active="route().current('profile.show')"
                            >
                                Profile
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link
                                :href="route('chat')"
                                :active="route().current('chat')"
                                class="hidden md:block"
                            >
                                Messages
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link
                                :href="route('community')"
                                :active="route().current('community')"
                            >
                                My communities
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link>
                                Newsfeed
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form
                                method="POST"
                                @submit.prevent="logout"
                                class="hidden md:block"
                            >
                                <jet-responsive-nav-link as="button">
                                    Log out
                                </jet-responsive-nav-link>
                            </form>

                            <p
                                class="hidden md:block text-left text-xl pb-3 pt-6"
                            >
                                Your movies
                            </p>

                            <jet-responsive-nav-link class="hidden md:block">
                                Movie diary
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link>
                                Movie collection
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link>
                                Random movie
                            </jet-responsive-nav-link>

                            <!-- Authentication -->
                            <form
                                method="POST"
                                @submit.prevent="logout"
                                class="md:hidden"
                            >
                                <jet-responsive-nav-link as="button">
                                    Log out
                                </jet-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
                <button
                    @click="
                        showingNavigationDropdown = !showingNavigationDropdown
                    "
                    class="w-1/2 h-full focus:outline-none md:hidden"
                ></button>
            </div>
        </nav>

        <div class="md:grid md:grid-cols-main">
            <div class="hidden md:block w-1/5 h-screen"></div>

            <div class="flex flex-col">
                <!-- Page Heading -->
                <header
                    class="bg-green text-white text-xl"
                    v-if="$slots.header"
                >
                    <div class="p-4">
                        <slot name="header"></slot>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="mb-16 md:mb-0">
                    <slot></slot>
                </main>
            </div>
        </div>

        <footer
            class="fixed w-screen h-16 bg-blue-primary bottom-0 flex items-center justify-evenly md:hidden"
        >
            <inertia-link>
                <img class="h-10" src="/img/diary.svg" alt="Diary"
            /></inertia-link>
            <inertia-link :href="route('dashboard')">
                <img class="h-10" src="/img/home.svg" alt="Home"
            /></inertia-link>
            <inertia-link :href="route('chat')">
                <img class="h-10" src="/img/message.svg" alt="Messages"
            /></inertia-link>
        </footer>
    </div>
</template>

<script>
    import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
    import { reactive } from "vue";
    import { Inertia } from '@inertiajs/inertia';

    export default {
        components: {
            JetResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            };
        },
        setup(){
            const form = reactive({
                search_movie: null,
            })

            function submit(){
                Inertia.post('/movie/search', form)
            }

            return { form, submit }
        },

        methods: {
            logout() {
                this.$inertia.post(route("logout"));
            },
        },
    };
</script>
