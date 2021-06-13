<template>
    <app-layout>
        <template #header>
            <h3 v-if="loading">
                loading
            </h3>
        </template>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import Welcome from "@/Jetstream/Welcome";

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        data(){
            return{
                loading: false,
            }
        },
        props: {
            movie: {
                type: Array,
                required: true,
            },
        },
        methods: {
            friendlyDate(str){
                var dateArray = str.substring(0, 10).split("-");
                dateArray.reverse();

                var date = (dateArray[0] + "/" + dateArray[1] + "/" + dateArray[2]);
                return date;
            },
            loading() {
                //Show Loader
                this.loading = true;

                //Waste 5 seconds
                setTimeout(() => {
                    this.loading = false;
                }, 5000)
            }
        },
    }
</script>
