import FeatureBoard from './components/FeatureBoard.vue'

function registerComponent() {
    if (window.Volet) {
        window.Volet.component('FeatureBoard', FeatureBoard);
    } else {
        console.log("Volet not found, retrying...");
        setTimeout(registerComponent, 100); // Retry after 100ms
    }
}

// Try registering once the DOM is ready
document.addEventListener("DOMContentLoaded", registerComponent);
