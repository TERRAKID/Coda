<template>
    <li>
        <img
            class="h-8 w-8 rounded-full object-cover"
            :src="user.profile_photo_url"
            :alt="user.name"
        />
        <p>{{ this.user.name }}</p>
        <p v-if="this.message">
            {{
                this.message.message.length > 20
                    ? this.message.message.slice(0, 20) + "..."
                    : this.message.message
            }}
            -
            {{
                ("0" + new Date(this.message.created_at).getHours()).slice(-2) +
                ":" +
                ("0" + new Date(this.message.created_at).getMinutes()).slice(-2)
            }}
        </p>
    </li>
</template>

<script>
    export default {
        props: ["user", "message"],
    };
</script>
