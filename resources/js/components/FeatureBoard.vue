<template>
    <div class="volet-feature-board vfb:h-full vfb:space-y-6">
        <FeatureList
            v-if="displayMode === 'feature-list'"
            :categories="categories"
            :routes="routes"
            :labels="labels"
            @update:display-mode="(mode) => displayMode = mode"
            @select-feature="(feature) => {
                displayMode = 'feature-view'
                selectedFeature = feature
            }"
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

        <FeatureView
            v-if="displayMode === 'feature-view'"
            :feature="selectedFeature"
            :labels="labels"
            :routes="routes"
            @close="() => displayMode = 'feature-list'"
            @update:display-mode="(mode) => displayMode = mode"
        />
    </div>
</template>

<script>
import FeatureCreateForm from "./FeatureCreateForm.vue";
import FeatureList from "./FeatureList.vue";
import FeatureView from "./FeatureView.vue";

export default {
    components: {
        FeatureCreateForm,
        FeatureList,
        FeatureView
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
            selectedFeature: null,
        }
    }
}
</script>
