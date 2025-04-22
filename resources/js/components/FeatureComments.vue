<template>
    <div class="space-y-4">
        <div v-for="comment in comments" :key="comment.id" class="bg-gray-50 p-4 rounded-lg space-y-2">
            <p class="text-gray-700">{{ comment.content }}</p>
            <small class="text-gray-500 text-sm">{{ new Intl.DateTimeFormat('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date(comment.created_at)) }}</small>
        </div>
    </div>
</template>

<script>
export default {
    name: "FeatureComments",
    props: {
        comments: {
            type: Array,
            default: () => []
        }
    }
}
</script>
