import FeatureBoard from './components/FeatureBoard.vue'
import FeatureList from './components/FeatureList.vue'
import FeatureCreateForm from './components/FeatureCreateForm.vue'
import FeatureView from './components/FeatureView.vue'

function registerComponents() {
    if (window.Volet) {
        window.Volet.component('FeatureBoard', FeatureBoard);
        window.Volet.component('FeatureList', FeatureList);
        window.Volet.component('FeatureCreateForm', FeatureCreateForm);
        window.Volet.component('FeatureView', FeatureView);
    } else {
        console.log("Volet not found, retrying...");
        setTimeout(registerComponents, 100);
    }
}

document.addEventListener("DOMContentLoaded", registerComponents);
