<template>
    <div v-if="message.user_id_1 === user.id">
        <img
            class="h-8 w-8 rounded-full object-cover"
            :src="user.profile_photo_url"
            :alt="user.name"
        />
        <p class="bg-blue-600">
            {{ message.message }}
        </p>
    </div>
    <div v-else>
        <p class="bg-red-600 text-right">
            {{ message.message }}
        </p>
        <img
            class="h-8 w-8 rounded-full object-cover"
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
