<template>
    <form @submit.prevent="submitComment" class="vfb:space-y-4">
        <textarea
            v-model="content"
            rows="2"
            class="vfb:w-full vfb:rounded-lg vfb:border vfb:border-gray-300 vfb:p-2 vfb:focus:border-blue-500 vfb:focus:ring-blue-500"
            :placeholder="labels.writeComment"
        ></textarea>
        <button
            type="submit"
            class="vfb:volet-feature-board-button vfb:volet-feature-board-button-primary"
        >
            {{ labels.post }}
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
