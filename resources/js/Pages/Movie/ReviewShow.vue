<template>
    <app-layout>
        <template #header>
            <h2>{{ review.name }}'s review for {{ review.title }} ({{ movie.release_date.substring(0, 4) }})</h2>
        </template>
    </app-layout>
</template>

<script type="text/javascript">
    import AppLayout from "@/Layouts/AppLayout";
    import { reactive } from "vue";

    export default {
        components: {
            AppLayout,
        },
        data() {
            return {
                monthYearCheck: null,
                stars: null,
            };
        },
        props: {
            review: {
                type: Array,
                required: false,
            },
            movie: {
                type: Array,
                required: false,
            },
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {
        },
    };
</script>
