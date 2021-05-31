<template>
    <div class="font-sans text-black antialiased">
        <div class="bg-blue-primary">
            <div class="min-h-screen flex flex-col items-center p-8">
                <div class="flex justify-center">
                    <img class="w-2/3" src="/img/logo.svg" alt="logo of Coda" />
                </div>

                <div
                    v-html="terms"
                    class="w-full mt-6 p-8 bg-white overflow-hidden prose rounded-3xl"
                ></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["terms"],
    };
</script>
