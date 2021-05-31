<template>
    <div
        class="min-h-screen flex flex-col items-center space-y-12 md:flex-row bg-blue-primary md:bg-hero-auth md:bg-right px-8 py-12 md:p-0"
    >
        <div
            class="bg-blue-primary w-3/4 md:w-2/5 text-white text-3xl text-center md:p-16 md:h-screen md:flex md:flex-col md:justify-center md:items-center md:gap-y-8"
        >
            <img class="md:w-2/3" src="/img/logo.svg" alt="logo of Coda" />
            <h1 class="hidden md:block font-semibold uppercase text-5xl my-6">
                Movies in close-up
            </h1>
            <p class="hidden md:block">
                Coda is the first true social media for movie enthusiasts.
            </p>
            <p class="hidden md:block">
                Join communities, watch parties and top the charts in trivia
                nights.
            </p>
        </div>
        <div class="w-full md:w-3/5 md:flex md:justify-center md:items-center">
            <div
                class="w-full p-8 bg-white overflow-hidden rounded-3xl md:max-w-md"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
