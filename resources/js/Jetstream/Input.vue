<template>
    <input
        class="border-2 border-green focus:border-green focus:ring-2 focus:ring-green rounded-lg text-xl"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    />
</template>

<script>
    export default {
        props: ["modelValue"],

        emits: ["update:modelValue"],

        methods: {
            focus() {
                this.$refs.input.focus();
            },
        },
    };
</script>

