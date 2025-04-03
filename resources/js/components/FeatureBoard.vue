<template>
    <div class="volet-feature-board">
        <div class="volet-feature-board-categories">
            <button
                v-for="category in categories"
                :key="category.slug"
                @click="selectCategory(category)"
                :class="[
                    'volet-feature-board-category-button',
                    { active: selectedCategory?.slug === category.slug }
                ]"
            >
                {{ category.name }}
            </button>
        </div>

        <div v-if="showForm" class="volet-feature-board-form">
            <form @submit.prevent="submitFeature">
                <div class="volet-feature-board-form-group">
                    <label class="volet-feature-board-label">{{ labels.title }}</label>
                    <input
                        type="text"
                        v-model="form.title"
                        @input="onTitleInput"
                        class="volet-feature-board-input"
                        :class="{ 'has-error': formErrors.title }"
                    >
                    <div v-if="formErrors.title" class="volet-feature-board-error">
                        {{ formErrors.title[0] }}
                    </div>
                </div>
                <div class="volet-feature-board-form-group">
                    <label class="volet-feature-board-label">{{ labels.description }}</label>
                    <textarea
                        v-model="form.description"
                        @input="onDescriptionInput"
                        rows="3"
                        class="volet-feature-board-textarea"
                        :class="{ 'has-error': formErrors.description }"
                    ></textarea>
                    <div v-if="formErrors.description" class="volet-feature-board-error">
                        {{ formErrors.description[0] }}
                    </div>
                </div>
                <div class="volet-feature-board-buttons">
                    <button
                        type="button"
                        @click="showForm = false"
                        class="volet-feature-board-button volet-feature-board-button-secondary"
                    >
                        {{ labels.cancel }}
                    </button>
                    <button
                        type="submit"
                        class="volet-feature-board-button volet-feature-board-button-primary"
                    >
                        {{ labels.submit }}
                    </button>
                </div>
            </form>
        </div>
        <div v-else class="volet-feature-board-form-group">
            <button
                @click="showForm = true"
                class="volet-feature-board-button volet-feature-board-button-primary"
            >
                {{ labels.suggestFeature }}
            </button>
        </div>

        <div v-if="selectedCategory" class="volet-feature-board-features">
            <div v-for="feature in filteredFeatures" :key="feature.id" class="volet-feature-board-feature">
                <div class="volet-feature-board-feature-header">
                    <h3 class="volet-feature-board-feature-title">{{ feature.title }}</h3>
                    <p class="volet-feature-board-feature-description">{{ feature.description }}</p>
                    <div class="volet-feature-board-feature-actions">
                        <button
                            @click="toggleVote(feature)"
                            :class="[
                                'volet-feature-board-vote-button',
                                { voted: feature.hasVoted }
                            ]"
                        >
                            <span>{{ feature.votes_count }} {{ labels.votes }}</span>
                        </button>
                        <button
                            @click="feature.showComments = !feature.showComments"
                            class="volet-feature-board-button volet-feature-board-button-secondary"
                        >
                            <span>{{ feature.comments?.length || 0 }} {{ labels.comments }}</span>
                        </button>
                        <span
                            :class="[
                                'volet-feature-board-status',
                                `volet-feature-board-status-${feature.status}`
                            ]"
                        >
                            {{ feature.status }}
                        </span>
                    </div>
                </div>

                <div v-if="feature.showComments" class="volet-feature-board-comments">
                    <div v-for="comment in feature.comments" :key="comment.id" class="volet-feature-board-comment">
                        <p class="volet-feature-board-comment-content">{{ comment.content }}</p>
                        <small class="volet-feature-board-comment-date">{{ comment.created_at }}</small>
                    </div>
                    <form @submit.prevent="submitComment(feature)" class="volet-feature-board-comment-form">
                        <textarea
                            v-model="commentForm[feature.id]"
                            rows="2"
                            class="volet-feature-board-textarea"
                            :placeholder="labels.writeComment"
                        ></textarea>
                        <button
                            type="submit"
                            class="volet-feature-board-button volet-feature-board-button-primary"
                        >
                            {{ labels.post }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
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
            features: [],
            selectedCategory: null,
            showForm: false,
            form: {
                title: '',
                description: '',
                category: ''
            },
            formErrors: {},
            commentForm: {},
            statusClasses: {
                pending: 'volet-feature-board-status-pending',
                approved: 'volet-feature-board-status-approved',
                rejected: 'volet-feature-board-status-rejected',
                completed: 'volet-feature-board-status-completed'
            }
        }
    },

    computed: {
        filteredFeatures() {
            return this.selectedCategory
                ? this.features[this.selectedCategory.slug] || []
                : []
        }
    },

    watch: {
        'form.title': {
            handler(newVal) {
                console.log('form.title changed:', newVal)
            },
            immediate: true
        },
        'form.description': {
            handler(newVal) {
                console.log('form.description changed:', newVal)
            },
            immediate: true
        }
    },

    async created() {
        this.selectedCategory = this.categories[0]
        await this.loadFeatures()
    },

    methods: {
        async loadFeatures() {
            try {
                const response = await fetch(this.routes.features)
                if (!response.ok) throw new Error('Network response was not ok')
                this.features = await response.json()
            } catch (error) {
                console.error('Error loading features:', error)
            }
        },

        selectCategory(category) {
            this.selectedCategory = category
        },

        async submitFeature() {
            // Reset errors before submitting
            this.formErrors = {}

            try {
                const response = await fetch(this.routes.store, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        ...this.form,
                        category: this.selectedCategory.slug
                    })
                })

                const data = await response.json()

                if (!response.ok) {
                    if (response.status === 422 && data.errors) {
                        this.formErrors = data.errors
                        return
                    }
                    throw new Error(data.message || 'Network response was not ok')
                }

                await this.loadFeatures()
                this.showForm = false
                this.form.title = ''
                this.form.description = ''
            } catch (error) {
                console.error('Error submitting feature:', error)
            }
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
        },

        onTitleInput(event) {
            console.log('Input event:', event.target.value)
            this.form.title = event.target.value
        },

        onDescriptionInput(event) {
            console.log('Description input:', event.target.value)
            this.form.description = event.target.value
        }
    }
}
</script>
