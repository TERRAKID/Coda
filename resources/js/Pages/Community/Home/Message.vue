<template>
    <div class="flex gap-2 items-center py-4">
        <img
            class="h-10 w-10 rounded-full object-cover border-2 border-black"
            :src="message.user.profile_photo_url"
            :alt="message.user.name"
        />
        <p class="text-white p-2 break-words w-full">
            {{ message.message }}
        </p>
    </div>
</template>

<script>
    export default {
        props: ["message", "community"],
    };
</script>
