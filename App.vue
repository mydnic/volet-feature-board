<template>
    <div style="height: 384px;width: 360px;" class="border overflow-auto border-b-gray-500 p-2 m-20">
        <FeatureBoard
            :labels="{
                'addFeatureButton': 'New feature',
                'featuresTitle': 'Features List',
                'featureCount': 'feature found',
                'featureCountPlural': 'features found',
                'createFormTitle': 'Request a Feature',
                'title': 'Title',
                'description': 'Description',
                'categoryPlaceholder': 'Select a Category',
                'cancel': 'Cancel',
                'submit': 'Submit',
                'back': 'Back',
                'votes': 'Votes',
                'comments': 'Comments',
                'addComment': 'Add a comment',
                'postComment': 'Submit',
                'commentInputPlaceholder': 'Write a comment...'
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
                'vote': 'http://feedback.test/volet/feature-board/features/_feature_id_/vote',
                'comments': 'http://feedback.test/volet/feature-board/features/_feature_id_/comments'
            }"
        />
    </div>
</template>

<script>
import FeatureBoard from "./resources/js/components/FeatureBoard.ce.vue";

export default {
    components: {
        FeatureBoard
    }
}
</script>
