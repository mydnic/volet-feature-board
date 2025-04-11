<template>
    <div class="vfb:space-y-4">
        <div v-for="comment in comments" :key="comment.id" class="vfb:bg-gray-50 vfb:p-4 vfb:rounded-lg vfb:space-y-2">
            <p class="vfb:text-gray-700">{{ comment.content }}</p>
            <small class="vfb:text-gray-500 vfb:text-sm">{{ new Intl.DateTimeFormat('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date(comment.created_at)) }}</small>
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
