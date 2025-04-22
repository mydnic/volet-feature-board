<template>
    <form @submit.prevent="submitComment" class="space-y-2 text-right">
        <textarea
            v-model="content"
            rows="2"
            class="vfb-input"
            :placeholder="labels.commentInputPlaceholder"
        ></textarea>
        <button
            type="submit"
            class="vfb-button"
        >
            {{ labels.postComment }}
        </button>
        <div v-if="success" class="text-green-600 text-sm mt-1 text-left">Comment posted!</div>
    </form>
</template>

<script>
import ApiService from '../services/ApiService';

export default {
    name: 'FeatureCommentForm',
    props: {
        labels: {
            type: Object,
            required: true
        },
        featureId: {
            type: [String, Number],
            required: true
        },
        routes: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            content: '',
            success: false
        }
    },
    methods: {
        async submitComment() {
            if (!this.content) return;
            try {
                const comment = await ApiService.post(
                    this.routes.comments.replace('_feature_id_', this.featureId),
                    { content: this.content }
                );
                this.$emit('created', comment);
                this.content = '';
                this.success = true;
                setTimeout(() => { this.success = false }, 2000);
            } catch (error) {
                console.error('Error submitting comment:', error);
            }
        }
    },
    emits: ['created']
}
</script>
