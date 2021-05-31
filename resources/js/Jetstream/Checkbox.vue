<template>
    <input
        type="checkbox"
        :value="value"
        v-model="proxyChecked"
        class="rounded border-2 border-green text-green focus:border-green focus:ring-2 focus:ring-green"
    />
</template>

<script>
    export default {
        emits: ["update:checked"],

        props: {
            checked: {
                type: [Array, Boolean],
                default: false,
            },
            value: {
                default: null,
            },
        },

        computed: {
            proxyChecked: {
                get() {
                    return this.checked;
                },

                set(val) {
                    this.$emit("update:checked", val);
                },
            },
        },
    };
</script>
