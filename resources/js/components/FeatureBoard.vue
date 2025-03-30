<template>
  <div class="volet-feature-board">
    <div class="volet-feature-board-header">
      <h2 class="volet-feature-board-title">Feature Requests</h2>
      <button @click="showNewFeatureForm = true" class="volet-feature-board-button">
        Suggest Feature
      </button>
    </div>

    <div v-if="showNewFeatureForm" class="volet-feature-board-form">
      <input v-model="newFeature.title" placeholder="Feature title" class="volet-feature-board-input" />
      <textarea v-model="newFeature.description" placeholder="Describe your feature request..." class="volet-feature-board-textarea"></textarea>
      <input v-model="newFeature.category" placeholder="Category" class="volet-feature-board-input" />
      <div class="volet-feature-board-form-actions">
        <button @click="submitFeature" class="volet-feature-board-button">Submit</button>
        <button @click="showNewFeatureForm = false" class="volet-feature-board-button-secondary">Cancel</button>
      </div>
    </div>

    <div v-for="(features, category) in groupedFeatures" :key="category" class="volet-feature-board-category">
      <h3 class="volet-feature-board-category-title">{{ category }}</h3>
      <div class="volet-feature-board-features">
        <div v-for="feature in features" :key="feature.id" class="volet-feature-board-feature">
          <div class="volet-feature-board-feature-header">
            <h4 class="volet-feature-board-feature-title">{{ feature.title }}</h4>
            <span :class="['volet-feature-board-feature-status', feature.status]">{{ feature.status }}</span>
          </div>
          <p class="volet-feature-board-feature-description">{{ feature.description }}</p>
          <div class="volet-feature-board-feature-actions">
            <button @click="toggleVote(feature)" class="volet-feature-board-vote-button">
              👍 {{ feature.votes_count }}
            </button>
            <button @click="feature.showComments = !feature.showComments" class="volet-feature-board-button-secondary">
              💬 {{ feature.comments.length }}
            </button>
          </div>
          <div v-if="feature.showComments" class="volet-feature-board-comments">
            <div v-for="comment in feature.comments" :key="comment.id" class="volet-feature-board-comment">
              <strong>{{ comment.user.name }}</strong>
              <p>{{ comment.content }}</p>
            </div>
            <div class="volet-feature-board-comment-form">
              <textarea v-model="feature.newComment" placeholder="Add a comment..." class="volet-feature-board-textarea"></textarea>
              <button @click="addComment(feature)" class="volet-feature-board-button">Comment</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const showNewFeatureForm = ref(false)
const groupedFeatures = ref({})
const newFeature = ref({
  title: '',
  description: '',
  category: ''
})

const fetchFeatures = async () => {
  const response = await axios.get('/feature-board/features')
  groupedFeatures.value = response.data
}

const submitFeature = async () => {
  await axios.post('/feature-board/features', newFeature.value)
  newFeature.value = { title: '', description: '', category: '' }
  showNewFeatureForm.value = false
  await fetchFeatures()
}

const toggleVote = async (feature) => {
  const response = await axios.post(`/feature-board/features/${feature.id}/vote`)
  feature.votes_count = response.data.votes_count
}

const addComment = async (feature) => {
  const response = await axios.post(`/feature-board/features/${feature.id}/comments`, {
    content: feature.newComment
  })
  feature.comments.push(response.data)
  feature.newComment = ''
}

onMounted(() => {
  fetchFeatures()
})
</script>

<style>
.volet-feature-board {
  padding: var(--volet-spacing);
  color: var(--volet-text);
}

.volet-feature-board-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: var(--volet-spacing);
}

.volet-feature-board-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin: 0;
}

.volet-feature-board-button {
  background-color: var(--volet-primary);
  color: var(--volet-background);
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s;
}

.volet-feature-board-button:hover {
  background-color: var(--volet-primary-hover);
}

.volet-feature-board-button-secondary {
  background-color: transparent;
  color: var(--volet-text);
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  border: 1px solid var(--volet-border);
  cursor: pointer;
  transition: background-color 0.2s;
}

.volet-feature-board-button-secondary:hover {
  background-color: var(--volet-border);
}

.volet-feature-board-form {
  margin-bottom: var(--volet-spacing);
  padding: var(--volet-spacing);
  border: 1px solid var(--volet-border);
  border-radius: 0.5rem;
}

.volet-feature-board-input,
.volet-feature-board-textarea {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 0.5rem;
  border: 1px solid var(--volet-border);
  border-radius: 0.375rem;
  background-color: var(--volet-background);
  color: var(--volet-text);
}

.volet-feature-board-textarea {
  min-height: 100px;
  resize: vertical;
}

.volet-feature-board-form-actions {
  display: flex;
  gap: 0.5rem;
  justify-content: flex-end;
}

.volet-feature-board-category {
  margin-bottom: var(--volet-spacing);
}

.volet-feature-board-category-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.volet-feature-board-feature {
  padding: var(--volet-spacing);
  border: 1px solid var(--volet-border);
  border-radius: 0.5rem;
  margin-bottom: 1rem;
}

.volet-feature-board-feature-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.volet-feature-board-feature-title {
  margin: 0;
  font-weight: 600;
}

.volet-feature-board-feature-status {
  font-size: 0.875rem;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
}

.volet-feature-board-feature-status.pending {
  background-color: #fef3c7;
  color: #92400e;
}

.volet-feature-board-feature-status.approved {
  background-color: #d1fae5;
  color: #065f46;
}

.volet-feature-board-feature-status.rejected {
  background-color: #fee2e2;
  color: #991b1b;
}

.volet-feature-board-feature-status.completed {
  background-color: #e0e7ff;
  color: #3730a3;
}

.volet-feature-board-feature-description {
  margin: 0.5rem 0;
}

.volet-feature-board-feature-actions {
  display: flex;
  gap: 0.5rem;
  margin-top: 1rem;
}

.volet-feature-board-comments {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid var(--volet-border);
}

.volet-feature-board-comment {
  margin-bottom: 1rem;
  padding: 0.5rem;
  background-color: var(--volet-background-alt);
  border-radius: 0.375rem;
}

.volet-feature-board-comment strong {
  font-weight: 600;
}

.volet-feature-board-comment p {
  margin: 0.25rem 0 0;
}

.volet-feature-board-comment-form {
  margin-top: 1rem;
}
</style>
<script setup lang="ts">
</script>
