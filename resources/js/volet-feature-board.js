import FeatureBoard from './components/FeatureBoard.vue'

function registerComponent() {
    if (window.Volet) {
        window.Volet.component('FeatureBoard', FeatureBoard);
    }
}

// Register once the DOM is ready
document.addEventListener("DOMContentLoaded", registerComponent);
