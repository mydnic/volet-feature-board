<template>
    <div class="volet-feature-board vfb:h-full vfb:space-y-6">
        <FeatureList
            v-if="displayMode === 'feature-list'"
            :categories="categories"
            :routes="routes"
            :labels="labels"
            @update:display-mode="(mode) => displayMode = mode"
        />

        <FeatureCreateForm
            v-if="displayMode === 'feature-create'"
            :categories="categories"
            :routes="routes"
            :labels="labels"
            @created="() => {
                loadFeatures()
                displayMode = 'feature-list'
            }"
            @close="() => displayMode = 'feature-list'"
            @update:display-mode="(mode) => displayMode = mode"
        />


<!--        <div v-if="selectedCategory" class="volet-feature-board-features">-->
<!--            <div v-for="feature in filteredFeatures" :key="feature.id" class="volet-feature-board-feature">-->
<!--                <div class="volet-feature-board-feature-header">-->
<!--                    <h3 class="volet-feature-board-feature-title">{{ feature.title }}</h3>-->
<!--                    <p class="volet-feature-board-feature-description">{{ feature.description }}</p>-->
<!--                    <div class="volet-feature-board-feature-actions">-->
<!--                        <button-->
<!--                            @click="toggleVote(feature)"-->
<!--                            :class="[-->
<!--                                'volet-feature-board-vote-button',-->
<!--                                { voted: feature.hasVoted }-->
<!--                            ]"-->
<!--                        >-->
<!--                            <span>{{ feature.votes_count }} {{ labels.votes }}</span>-->
<!--                        </button>-->
<!--                        <button-->
<!--                            @click="feature.showComments = !feature.showComments"-->
<!--                            class="volet-feature-board-button volet-feature-board-button-secondary"-->
<!--                        >-->
<!--                            <span>{{ feature.comments?.length || 0 }} {{ labels.comments }}</span>-->
<!--                        </button>-->
<!--                        <span-->
<!--                            :class="[-->
<!--                                'volet-feature-board-status',-->
<!--                                `volet-feature-board-status-${feature.status}`-->
<!--                            ]"-->
<!--                        >-->
<!--                            {{ feature.status }}-->
<!--                        </span>-->
<!--                    </div>-->
<!--                </div>-->

<!--                <div v-if="feature.showComments" class="volet-feature-board-comments">-->
<!--                    <div v-for="comment in feature.comments" :key="comment.id" class="volet-feature-board-comment">-->
<!--                        <p class="volet-feature-board-comment-content">{{ comment.content }}</p>-->
<!--                        <small class="volet-feature-board-comment-date">{{ comment.created_at }}</small>-->
<!--                    </div>-->
<!--                    <form @submit.prevent="submitComment(feature)" class="volet-feature-board-comment-form">-->
<!--                        <textarea-->
<!--                            v-model="commentForm[feature.id]"-->
<!--                            rows="2"-->
<!--                            class="volet-feature-board-textarea"-->
<!--                            :placeholder="labels.writeComment"-->
<!--                        >
</textarea>-->
<!--                        <button-->
<!--                            type="submit"-->
<!--                            class="volet-feature-board-button volet-feature-board-button-primary"-->
<!--                        >-->
<!--                            {{ labels.post }}-->
<!--                        </button>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
import FeatureCreateForm from "./FeatureCreateForm.vue";
import FeatureList from "./FeatureList.vue";

export default {
    components: {
        FeatureCreateForm,
        FeatureList
    },

    props: {
        categories: {
            type: Array,
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
            displayMode: 'feature-list',
        }
    },

    created() {
        this.loadFeatures()
    },

    methods: {
        loadFeatures() {
            fetch(this.routes.features)
                .then(response => response.json())
                .then(data => {
                    this.features = data
                })
                .catch(error => {
                    console.error('Error loading features:', error)
                })
        },

        async toggleVote(feature) {
            try {
                const response = await fetch(this.routes.vote.replace('{id}', feature.id), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })

                if (!response.ok) throw new Error('Network response was not ok')
                const data = await response.json()

                feature.votes_count = data.votes_count
                feature.hasVoted = data.action === 'added'
            } catch (error) {
                console.error('Error toggling vote:', error)
            }
        },

        async submitComment(feature) {
            if (!this.commentForm[feature.id]) return

            try {
                const response = await fetch(this.routes.comment.replace('{id}', feature.id), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        content: this.commentForm[feature.id]
                    })
                })

                if (!response.ok) throw new Error('Network response was not ok')
                const comment = await response.json()

                if (!feature.comments) feature.comments = []
                feature.comments.push(comment)
                this.commentForm[feature.id] = ''
            } catch (error) {
                console.error('Error submitting comment:', error)
            }
        }
    }
}
</script>
