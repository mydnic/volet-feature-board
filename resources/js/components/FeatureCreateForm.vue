<template>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-semibold text-zinc-900">{{ labels.createFormTitle }}</h1>
            </div>
            <button
                @click="$emit('close')"
                class="vfb-button-outline"
                type="button"
                aria-haspopup="dialog"
            >
                <img src="https://api.iconify.design/lucide:x.svg?color=%2371717b" alt="add feature" class="size-4 mr-2">
                {{ labels.cancel }}
            </button>
        </div>

        <form
            class="space-y-6"
            @submit.prevent="submit"
        >
            <div>
                <select
                    v-model="form.category"
                    class="vfb-input"
                    :class="{ 'border-red-500! text-red-800': formErrors.category }"
                >
                    <option :value="null" selected>{{ labels.categoryPlaceholder }}</option>
                    <option v-for="category in categories" :key="category.id" :value="category.slug">
                        {{ category.name }}
                    </option>
                </select>
                <div v-if="formErrors.category" class="text-sm text-red-500">
                    {{ formErrors.category[0] }}
                </div>
            </div>
            <div>
                <input
                    type="text"
                    v-model="form.title"
                    :placeholder="labels.title"
                    class="vfb-input"
                    :class="{ 'ring-red-500! text-red-800': formErrors.title }"
                >
                <div v-if="formErrors.title" class="text-sm text-red-500">
                    {{ formErrors.title[0] }}
                </div>
            </div>
            <div>
                <textarea
                    type="text"
                    :placeholder="labels.description"
                    v-model="form.description"
                    class="vfb-input"
                    :class="{ 'ring-red-500! text-red-800': formErrors.description }"
                ></textarea>
                <div v-if="formErrors.description" class="text-sm text-red-500">
                    {{ formErrors.description[0] }}
                </div>
            </div>
            <div class="text-right">
                <button class="vfb-button" :disabled="isLoading" :class="{'opacity-50': isLoading}">
                    {{ labels.submit }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import ApiService from '../services/ApiService'

export default {
    name: 'FeatureCreateForm',
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
            formErrors: {},
            isLoading: false,
            form: {
                category: null,
                title: '',
                description: ''
            }
        }
    },
    methods: {
        async submit() {
            this.formErrors = {}
            this.isLoading = true

            try {
                await ApiService.post(this.routes.store, this.form)
                this.$emit('created')
                this.$emit('close')
            } catch (error) {
                if (error.response?.data?.errors) {
                    this.formErrors = error.response.data.errors
                }
                console.error('Error submitting feature:', error)
            } finally {
                this.isLoading = false
            }
        }
    },
    emits: ['created', 'close']
}
</script>
