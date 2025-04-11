<template>
    <div class="vfb:space-y-6">
        <div class="vfb:flex vfb:items-center vfb:justify-between">
            <div>
                <h1 class="vfb:text-xl vfb:font-semibold vfb:text-zinc-900">Request a Feature</h1>
            </div>
            <button
                @click="$emit('close')"
                class="volet-button vfb:flex vfb:items-center vfb:bg-white! vfb:ring-1 vfb:ring-zinc-300 vfb:text-zinc-500!"
                type="button"
                aria-haspopup="dialog"
            >
                <img src="https://api.iconify.design/lucide:x.svg?color=%2371717b" alt="add feature" class="vfb:size-4 vfb:-ml-1 vfb:mr-2">
                Cancel
            </button>
        </div>

        <form
            class="vfb:space-y-6"
            @submit.prevent="submit"
        >
            <div>
                <select
                    v-model="form.category"
                    class="vfb:block vfb:w-full vfb:px-3 vfb:py-2 vfb:text-base vfb:text-zinc-700 vfb:ring-1 vfb:ring-zinc-100 vfb:rounded-md vfb:shadow-sm vfb:focus:vfb:outline-none vfb:focus:vfb:ring vfb:focus:vfb:ring-zinc-200 vfb:focus:vfb:border-zinc-200"
                    :class="{ 'vfb:border-red-500! vfb:text-red-800': formErrors.category }"
                >
                    <option :value="null" selected>Select a category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.slug">
                        {{ category.name }}
                    </option>
                </select>
                <div v-if="formErrors.category" class="vfb:text-sm vfb:text-red-500">
                    {{ formErrors.category[0] }}
                </div>
            </div>
            <div>
                <input
                    type="text"
                    v-model="form.title"
                    placeholder="Title"
                    class="vfb:block vfb:w-full vfb:px-3 vfb:py-2 vfb:text-base vfb:text-zinc-700 vfb:ring-1 vfb:ring-zinc-100 vfb:rounded-md vfb:shadow-sm vfb:focus:vfb:outline-none vfb:focus:vfb:ring vfb:focus:vfb:ring-zinc-200 vfb:focus:vfb:border-zinc-200"
                    :class="{ 'vfb:ring-red-500! vfb:text-red-800': formErrors.title }"
                >
                <div v-if="formErrors.title" class="vfb:text-sm vfb:text-red-500">
                    {{ formErrors.title[0] }}
                </div>
            </div>
            <div>
                <textarea
                    type="text"
                    placeholder="Description"
                    v-model="form.description"
                    class="vfb:block vfb:w-full vfb:px-3 vfb:py-2 vfb:text-base vfb:text-zinc-700 vfb:ring-1 vfb:ring-zinc-100 vfb:rounded-md vfb:shadow-sm vfb:focus:vfb:outline-none vfb:focus:vfb:ring vfb:focus:vfb:ring-zinc-200 vfb:focus:vfb:border-zinc-200"
                    :class="{ 'vfb:ring-red-500! vfb:text-red-800': formErrors.description }"
                ></textarea>
                <div v-if="formErrors.description" class="vfb:text-sm vfb:text-red-500">
                    {{ formErrors.description[0] }}
                </div>
            </div>
            <div class="vfb:text-right">
                <button class="volet-button" :disabled="isLoading" :class="{'vfb:opacity-50': isLoading}">
                    Save
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "FeatureCreateForm",
    emits: ['created', 'close'],

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
        submit() {
            this.formErrors = {}
            this.isLoading = true
            fetch(this.routes.store, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    ...this.form,
                })
            })
                .then(response => response.json())
                .then((response) => {
                    // this.$emit('close')
                    if (response.errors) {
                        this.formErrors = response.errors
                    } else {
                        this.$emit('close')
                    }
                })
                .catch(error => {
                    this.formErrors = error.response.errors
                    console.error('Error submitting feature:', error, error.response)
                })
                .finally(() => {
                    this.isLoading = false
                })
        },
    }
}
</script>
