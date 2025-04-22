<template>
    <div class="space-y-3" v-if="feature">
        <div class="flex items-start space-x-4 justify-between">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900">{{ feature.title }}</h1>
            </div>
            <button
                @click="$emit('close')"
                class="vfb-button-outline shrink-0"
                type="button"
                aria-haspopup="dialog"
            >
                <img src="https://api.iconify.design/lucide:x.svg?color=%2371717b" alt="add feature" class="size-4 mr-2">
                {{ labels.back }}
            </button>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center bg-zinc-100 px-2 py-1 rounded-full">
                <img :src="feature.category.icon" :alt="feature.category" class="size-4">
                <div class="text-sm text-gray-500 ml-2">
                    {{ feature.category.name }}
                </div>
            </div>
            <FeatureStatus :status="feature.status" />
            <div class="grow"></div>
            <div class="flex items-center space-x-3">
                <FeatureVote
                    :votes-count="feature.votes_count"
                    :has-voted="feature.has_voted"
                    :labels="labels"
                    @vote="toggleVote"
                />
            </div>
        </div>
        <p class="text-gray-600 overflow-hidden">{{ feature.description }}</p>

        <div class="space-y-4 pt-4 border-t border-zinc-200">
            <div class="text-gray-500 text-sm font-semibold">Comments</div>
            <FeatureCommentForm
                :labels="labels"
                :feature-id="feature.id"
                :routes="routes"
                @created="addComment"
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
    name: 'FeatureView',
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
                const data = await ApiService.post(this.routes.vote.replace('_feature_id_', this.feature.id));
                this.feature.votes_count = data.votes_count;
                this.feature.has_voted = data.action === 'added';
            } catch (error) {
                console.error('Error toggling vote:', error);
            }
        },
        addComment(comment) {
            if (!this.feature.comments) this.feature.comments = [];
            this.feature.comments.push(comment);
        }
    },
    emits: ['close']
}
</script>
