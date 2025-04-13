<template>
    <div class="vfb:space-y-6">
        <div class="vfb:flex vfb:items-center vfb:justify-between">
            <div>
                <h1 class="vfb:text-xl vfb:font-semibold vfb:text-zinc-900">{{ labels.featuresTitle }}</h1>
                <p class="vfb:mt-1 vfb:text-sm vfb:text-zinc-500">{{ features.length }} {{ features.length > 1 ? labels.featureCountPlural : labels.featureCount }}</p>
            </div>
            <button
                @click="$emit('update:display-mode', 'feature-create')"
                class="volet-button vfb:flex vfb:items-center"
                type="button"
                aria-haspopup="dialog"
            >
                <img src="https://api.iconify.design/lucide:plus.svg?color=%23FFF" alt="add feature"
                     class="vfb:size-4 vfb:mr-2">
                {{ labels.addFeatureButton }}
            </button>
        </div>

        <button
            v-for="feature in features"
            :key="feature.id"
            class="vfb:rounded-xl vfb:p-2 vfb:transition-all vfb:border vfb:border-zinc-100 vfb:shadow-sm vfb:text-left vfb:hover:bg-zinc-50 vfb:cursor-pointer vfb:block vfb:w-full"
            @click="$emit('select-feature', feature)"
        >
            <div class="vfb:flex vfb:items-center">
                <div class="vfb:flex vfb:items-center vfb:bg-zinc-100 vfb:px-2 vfb:py-1 vfb:rounded-full">
                    <img :src="feature.category.icon" :alt="feature.category" class="size-4">
                    <div class="vfb:text-sm vfb:text-gray-500 vfb:ml-2">
                        {{ feature.category.name }}
                    </div>
                </div>
                <div class="vfb:grow"></div>
                <div
                    class="vfb:flex vfb:items-center vfb:px-2 vfb:py-1 vfb:rounded-full"
                    :class="[
                        feature.has_voted ? 'vfb:bg-blue-600 vfb:text-white' : 'vfb:bg-blue-100 vfb:text-blue-600'
                    ]"
                >
                    <img :src="`https://api.iconify.design/lucide:thumbs-up.svg?color=%23${feature.has_voted ? 'FFF' : '2563eb'}`" alt="like"
                         class="size-4 vfb:mr-2">
                    <span class="vfb:text-sm">{{ feature.votes_count }}</span>
                </div>
            </div>

            <div class="vfb:mt-2">
                <h3 class="vfb:text-lg vfb:font-semibold vfb:line-clamp-2 vfb:text-zinc-900">
                    {{ feature.title }}
                </h3>
                <p class="vfb:mt-1 vfb:line-clamp-1 vfb:text-sm vfb:text-zinc-500">
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
