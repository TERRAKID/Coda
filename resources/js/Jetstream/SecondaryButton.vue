<template>
    <button
        :type="type"
        class="text-center px-4 py-2.5 bg-green bg-opacity-50 rounded-lg text-xl text-white focus:outline-none hover:bg-opacity-70 active:bg-opacity-60 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: "button",
            },
        },
    };
</script>
