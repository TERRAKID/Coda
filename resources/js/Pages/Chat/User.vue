<template>
    <div
        class="
            md:px-8
            px-4
            md:py-4
            py-2
            flex
            items-center
            gap-4
            hover:bg-green hover:bg-opacity-25
            hover:cursor-pointer
        "
    >
        <img
            class="h-10 w-10 rounded-full object-cover border-2 border-black"
            :src="user.profile_photo_url"
            :alt="user.name"
        />
        <div>
            <p>{{ this.user.name ? this.user.name : "unknown" }}</p>
            <p class="text-base" v-if="!this.message">No messages</p>
            <p v-if="this.message" class="text-base">
                <span class="font-serif text-black text-opacity-50">
                    {{
                        this.message.message.length > 20
                            ? this.message.message.slice(0, 20) + "..."
                            : this.message.message
                    }}</span
                >
                -
                {{
                    ("0" + new Date(this.message.created_at).getHours()).slice(
                        -2
                    ) +
                    ":" +
                    (
                        "0" + new Date(this.message.created_at).getMinutes()
                    ).slice(-2)
                }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["user", "message"],
    };
</script>
