<script setup>
import {computed} from "vue";

props = defineProps({
    status: String
})

computed({
    statusClasses: {
        pending: 'volet-feature-board-status-pending',
        approved: 'volet-feature-board-status-approved',
        rejected: 'volet-feature-board-status-rejected',
        completed: 'volet-feature-board-status-completed'
    }
})
</script>

<template>
    <div>
        {{ props.status }}
    </div>
</template>

<style scoped>

</style>
