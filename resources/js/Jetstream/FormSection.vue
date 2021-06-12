<template>
    <div>
        <jet-section-title
            :hasTitle="hasTitle"
            :hasDescription="hasDescription"
        >
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
        </jet-section-title>
        <div>
            <form @submit.prevent="$emit('submitted')">
                <div>
                    <slot name="form"></slot>
                </div>

                <div
                    class="flex items-center justify-end py-4 text-right"
                    v-if="hasActions"
                >
                    <slot name="actions"></slot>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from "./SectionTitle";

    export default {
        emits: ["submitted"],

        components: {
            JetSectionTitle,
        },

        computed: {
            hasActions() {
                return !!this.$slots.actions;
            },

            hasTitle() {
                return !!this.$slots.title;
            },

            hasDescription() {
                return !!this.$slots.description;
            },
        },
    };
</script>
