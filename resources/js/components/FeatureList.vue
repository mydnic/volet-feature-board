<template>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900">{{ labels.featuresTitle }}</h1>
                <p class="mt-1 text-sm text-zinc-500">{{ features.length }} {{ features.length > 1 ? labels.featureCountPlural : labels.featureCount }}</p>
            </div>
            <button
                @click="$emit('update:display-mode', 'feature-create')"
                class="vfb-button"
                type="button"
                aria-haspopup="dialog"
            >
                <img src="https://api.iconify.design/lucide:plus.svg?color=%23FFF" alt="add feature"
                     class="size-4 mr-2">
                {{ labels.addFeatureButton }}
            </button>
        </div>

        <button
            v-for="feature in features"
            :key="feature.id"
            class="vfb-card"
            @click="$emit('select-feature', feature)"
        >
            <div class="flex items-center">
                <div class="flex items-center bg-zinc-100 px-2 py-1 rounded-full">
                    <img :src="feature.category.icon" :alt="feature.category" class="size-4">
                    <div class="text-sm text-gray-500 ml-2">
                        {{ feature.category.name }}
                    </div>
                </div>
                <div class="grow"></div>
                <div
                    class="flex items-center px-2 py-1 rounded-full"
                    :class="[
                        feature.has_voted ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600'
                    ]"
                >
                    <img :src="`https://api.iconify.design/lucide:thumbs-up.svg?color=%23${feature.has_voted ? 'FFF' : '2563eb'}`" alt="like"
                         class="size-4 mr-2">
                    <span class="text-sm">{{ feature.votes_count }}</span>
                </div>
            </div>

            <div class="mt-2">
                <h3 class="text-lg font-semibold line-clamp-2 text-zinc-900">
                    {{ feature.title }}
                </h3>
                <p class="mt-1 line-clamp-1 text-sm text-zinc-500">
                    {{ feature.description }}
                </p>
            </div>
        </button>
    </div>
</template>

<script>
import ApiService from '../services/ApiService'

export default {
    name: "FeatureList",

    emits: ['update:display-mode', 'select-feature'],

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

    data () {
        return {
            features: []
        }
    },

    created() {
        this.loadFeatures()
    },

    methods: {
        async loadFeatures() {
            try {
                this.features = await ApiService.request(this.routes.features);
            } catch (error) {
                console.error('Error loading features:', error);
            }
        }
    }
}
</script>
