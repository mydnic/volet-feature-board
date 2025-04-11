<template>
    <div style="height: 384px;width: 360px;" class="vfb:border vfb:border-b-gray-500 vfb:p-2 vfb:m-20">
        <FeatureBoard
            :labels="{
                'suggestFeature': '+ New feature',
                'title': 'Title',
                'description': 'Description',
                'cancel': 'Cancel',
                'submit': 'Submit',
                'votes': 'Votes',
                'comments': 'Comments',
                'addComment': 'Add a comment',
                'post': 'Post',
            }"
            :categories="[
                {
                    'name': 'Idea',
                    'slug': 'idea',
                    'icon': 'https://api.iconify.design/lucide:lightbulb.svg?color=%23888888'
                },
                {
                    'name': 'Issue',
                    'slug': 'issue',
                    'icon': 'https://api.iconify.design/lucide:trash.svg?color=%23888888'
                }
            ]"
            :routes="{
                'features': 'http://feedback.test/volet/feature-board/features',
                'store': 'http://feedback.test/volet/feature-board/features',
                'vote': 'http://feedback.test/volet/feature-board/features/{id}/vote',
                'comment': 'http://feedback.test/volet/feature-board/features/{id}/comment'
            }"
        />
    </div>
</template>

<script>
import FeatureBoard from "./resources/js/components/FeatureBoard.vue";

export default {
    components: {
        FeatureBoard
    }
}
</script>
