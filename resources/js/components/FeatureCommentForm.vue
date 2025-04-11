<template>
    <form @submit.prevent="submitComment" class="vfb:space-y-2 vfb:text-right">
        <textarea
            v-model="content"
            rows="2"
            class="vfb:w-full vfb:rounded-lg vfb:border vfb:border-gray-300 vfb:p-2 vfb:focus:border-blue-500 vfb:focus:ring-blue-500"
            :placeholder="labels.commentInputPlaceholder"
        ></textarea>
        <button
            type="submit"
            class="volet-button"
        >
            {{ labels.postComment }}
        </button>
    </form>
</template>

<script>
export default {
    name: "FeatureCommentForm",
    props: {
        labels: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            content: ''
        }
    },
    methods: {
        submitComment() {
            if (!this.content) return
            this.$emit('submit', this.content)
            this.content = ''
        }
    }
}
</script>
