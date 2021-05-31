<template>
    <div>
        <button :class="classes" class="w-full" v-if="as == 'button'">
            <slot></slot>
        </button>

        <inertia-link :href="href" :class="classes" v-else>
            <slot></slot>
        </inertia-link>
    </div>
</template>

<script>
    export default {
        props: ["active", "href", "as"],

        computed: {
            classes() {
                return this.active
                    ? "block py-3 text-lg text-center text-green hover:text-green focus:outline-none focus:text-green transition duration-150 ease-in-out md:text-xl"
                    : "block py-3 text-lg text-center text-white hover:text-green focus:outline-none focus:text-green transition duration-150 ease-in-out md:text-xl";
            },
        },
    };
</script>
