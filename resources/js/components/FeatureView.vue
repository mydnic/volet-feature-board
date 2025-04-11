<template>
    <div class="vfb:space-y-3" v-if="feature">
        <div class="vfb:flex vfb:items-start vfb:space-x-4 vfb:justify-between">
            <div>
                <h1 class="vfb:text-xl vfb:font-semibold vfb:text-zinc-900">{{ feature.title }}</h1>
            </div>
            <button
                @click="$emit('close')"
                class="volet-button vfb:shrink-0 vfb:flex vfb:items-center vfb:bg-white! vfb:ring-1 vfb:ring-zinc-300 vfb:text-zinc-500!"
                type="button"
                aria-haspopup="dialog"
            >
                <img src="https://api.iconify.design/lucide:x.svg?color=%2371717b" alt="add feature" class="vfb:size-4 vfb:-ml-1 vfb:mr-2">
                Back
            </button>
        </div>
        <div class="vfb:flex vfb:items-center vfb:space-x-4">
            <div class="vfb:flex vfb:items-center vfb:bg-zinc-100 vfb:px-2 vfb:py-1 vfb:rounded-full">
                <img :src="feature.category.icon" :alt="feature.category" class="size-4">
                <div class="vfb:text-sm vfb:text-gray-500 vfb:ml-2">
                    {{ feature.category.name }}
                </div>
            </div>
            <FeatureStatus :status="feature.status" />
            <div class="vfb:grow"></div>
            <div class="vfb:flex vfb:items-center vfb:space-x-3">
                <FeatureVote
                    :votes-count="feature.votes_count"
                    :has-voted="feature.has_voted"
                    :labels="labels"
                    @vote="toggleVote"
                />
            </div>
        </div>
        <p class="vfb:text-gray-600 vfb:overflow-hidden">{{ feature.description }}</p>

        <div class="vfb:space-y-4 vfb:pt-4 vfb:border-t vfb:border-zinc-200">
            <div class="vfb:text-gray-500 vfb:text-sm vfb:font-semibold">Comments</div>
            <FeatureCommentForm
                :labels="labels"
                @submit="submitComment"
            />
            <FeatureComments :comments="feature.comments" />
        </div>
    </div>
</template>

<script>
import FeatureVote from './FeatureVote.vue'
import FeatureComments from './FeatureComments.vue'
import FeatureCommentForm from './FeatureCommentForm.vue'
import FeatureStatus from './FeatureStatus.vue'
import ApiService from '../services/ApiService';

export default {
    name: "FeatureView",
    components: {
        FeatureVote,
        FeatureComments,
        FeatureCommentForm,
        FeatureStatus
    },
    props: {
        feature: {
            type: Object,
            required: true
        },
        routes: {
            type: Object,
            required: true
        },
        labels: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            showComments: false
        }
    },
    methods: {
        async toggleVote() {
            try {
                const data = await ApiService.post(this.routes.vote.replace('{id}', this.feature.id));
                this.feature.votes_count = data.votes_count;
                this.feature.has_voted = data.action === 'added';
            } catch (error) {
                console.error('Error toggling vote:', error);
            }
        },

        async submitComment(content) {
            try {
                const comment = await ApiService.post(
                    this.routes.comment.replace('{id}', this.feature.id),
                    { content }
                );

                if (!this.feature.comments) this.feature.comments = [];
                this.feature.comments.push(comment);
            } catch (error) {
                console.error('Error submitting comment:', error);
            }
        }
    }
}
</script>
