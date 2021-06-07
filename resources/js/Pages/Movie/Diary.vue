<template>
    <app-layout>
        <div>
            <div>
                <h2>November 2020</h2>
            </div>
            <div>
                <div>
                <p>27</p>
                <div style="background-image: url('/film-posters/game-night.jpg');"></div>
                </div>
                <div>
                    <h3>Game Night</h3>
                    <div>
                        <img src="" alt="">
                        <img src="" alt="">
                        <img src="" alt="">
                        <img src="" alt="">
                        <img src="" alt="">
                    </div>
                </div>
            </div>
        </div>
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
            return {};
        },
        props: {
            reviews: {
                type: Array,
                required: false,
            },
            errors: {
                type: Array,
                required: false,
            },
        },
        methods: {},
    };
</script>
