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
            <div class="pb-4">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import JetSectionTitle from "./SectionTitle";

    export default {
        components: {
            JetSectionTitle,
        },

        computed: {
            hasTitle() {
                return !!this.$slots.title;
            },

            hasDescription() {
                return !!this.$slots.description;
            },
        },
    };
</script>
