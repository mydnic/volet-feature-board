<template>
    <span :class="[
        'vfb:px-3 vfb:py-1 vfb:rounded-full vfb:flex vfb:items-center vfb:text-sm',
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
                pending: 'vfb:bg-yellow-100 vfb:text-yellow-800',
                approved: 'vfb:bg-blue-100 vfb:text-blue-800',
                rejected: 'vfb:bg-red-100 vfb:text-red-800',
                completed: 'vfb:bg-green-100 vfb:text-green-800'
            }
        }
    }
}
</script>
