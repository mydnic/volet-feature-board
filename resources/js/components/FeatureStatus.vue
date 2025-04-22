<template>
    <span :class="[
        'px-3 py-1 rounded-full flex items-center text-sm',
        statusClasses[status] || statusClasses.pending
    ]">
        {{ status }}
    </span>
</template>

<script>
export default {
    name: 'FeatureStatus',
    props: {
        status: {
            type: String,
            default: 'pending'
        }
    },
    computed: {
        statusClasses() {
            return {
                pending: 'bg-yellow-100 text-yellow-800',
                approved: 'bg-blue-100 text-blue-800',
                rejected: 'bg-red-100 text-red-800',
                completed: 'bg-green-100 text-green-800'
            }
        }
    }
}
</script>
