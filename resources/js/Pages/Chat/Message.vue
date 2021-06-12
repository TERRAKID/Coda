<template>
    <div v-if="message.user_id_1 === user.id" class="flex gap-2 items-center">
        <img
            class="h-10 w-10 rounded-full object-cover border-2 border-black"
            :src="user.profile_photo_url"
            :alt="user.name"
        />
        <p
            class="
                bg-blue-primary
                text-white
                p-2
                rounded-lg
                max-w-sm
                break-words
            "
        >
            {{ message.message }}
        </p>
    </div>
    <div v-else class="flex gap-2 items-center justify-end">
        <p
            class="
                bg-green
                text-white text-right
                p-2
                rounded-lg
                max-w-sm
                break-words
            "
        >
            {{ message.message }}
        </p>
        <img
            class="h-10 w-10 rounded-full object-cover border-2 border-black"
            :src="$page.props.user.profile_photo_url"
            :alt="$page.props.user.name"
        />
    </div>
</template>

<script>
    export default {
        props: ["message", "user"],
    };
</script>
