<template>
    <div>
        <div>
            <h3 class="text-xl mb-4" v-if="hasTitle">
                <slot name="title"></slot>
            </h3>

            <p class="mt-1" v-if="hasDescription">
                <slot name="description"></slot>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["hasTitle", "hasDescription"],
    };
</script>
